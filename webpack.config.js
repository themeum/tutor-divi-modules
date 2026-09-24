const fs = require('fs');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');

const babelLoader = {
	loader: 'babel-loader',
	options: {
		compact: false,
		presets: [
			['@babel/preset-env', {
				modules: false,
				targets: '> 5%',
			}],
			'@babel/preset-react',
		],
		cacheDirectory: false,
	},
};

const jsRule = {
	test: /\.jsx?$/,
	exclude: /node_modules/,
	use: [
		{
			loader: 'thread-loader',
			options: {
				workers: -1,
			},
		},
		babelLoader,
	],
};

class DiviBuilderPluginCss {
	apply(compiler) {
		compiler.hooks.afterEmit.tap('DiviBuilderPluginCss', () => {
			const source = path.join(__dirname, 'styles/style.min.css');
			const destination = path.join(__dirname, 'styles/style-dbp.min.css');

			if (!fs.existsSync(source)) {
				return;
			}

			const rawCss = fs.readFileSync(source, 'utf8');
			const css = rawCss.replace(
				/url\((['"]?)[^)'"]*media\/([^)'"]+)\1\)/g,
				'url($1../media/$2$1)'
			);

			if (css !== rawCss) {
				fs.writeFileSync(source, css);
			}

			const prefixed = css.replace(/(^|})(\s*)([^@}{][^{]*)\{/g, (match, closer, space, selectors) => {
				const next = selectors.split(',').map((selector) => {
					const trimmed = selector.trim();

					if (!trimmed || trimmed.startsWith('.et_divi_builder')) {
						return trimmed;
					}

					return `.et_divi_builder #et_builder_outer_content ${trimmed}`;
				}).join(',');

				return `${closer}${space}${next}{`;
			});

			fs.writeFileSync(destination, prefixed);
		});
	}
}

function divi4BuilderConfig(isProduction) {
	return {
		name: 'divi4-builder',
		mode: isProduction ? 'production' : 'development',
		devtool: isProduction ? false : 'cheap-module-source-map',
		entry: {
			'builder-bundle': './includes/loader.js',
		},
		externals: {
			jquery: 'jQuery',
			react: 'React',
			'react-dom': 'ReactDOM',
		},
		module: {
			rules: [
				jsRule,
				{
					test: /\.css$/,
					use: [
						MiniCssExtractPlugin.loader,
						{
							loader: 'css-loader',
							options: {
								url: true,
							},
						},
					],
				},
				{
					test: /\.(eot|svg|ttf|woff|woff2|gif|png|jpe?g)$/i,
					type: 'asset/resource',
					generator: {
						filename: '../media/[name][ext]',
					},
				},
			],
		},
		resolve: {
			extensions: ['.js', '.jsx', '.json'],
		},
		output: {
			filename: '[name].min.js',
			path: path.resolve(__dirname, 'scripts'),
			clean: false,
		},
		performance: {
			hints: false,
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: '../styles/style.min.css',
			}),
			new DiviBuilderPluginCss(),
		],
	};
}

function divi4FrontendConfig(isProduction) {
	return {
		name: 'divi4-frontend',
		mode: isProduction ? 'production' : 'development',
		entry: {
			'frontend-bundle': './scripts/frontend.js',
		},
		externals: {
			jquery: 'jQuery',
		},
		module: {
			rules: [jsRule],
		},
		resolve: {
			extensions: ['.js', '.jsx', '.json'],
		},
		output: {
			filename: '[name].min.js',
			path: path.resolve(__dirname, 'scripts'),
			clean: false,
		},
	};
}

function divi5Config(isProduction) {
	return {
		name: 'divi5',
		mode: isProduction ? 'production' : 'development',
		entry: {
			bundle: './includes/div5modules/index.jsx',
		},
		externals: {
			react: ['vendor', 'React'],
			'@wordpress/hooks': ['vendor', 'wp', 'hooks'],
			'@divi/rest': ['divi', 'rest'],
			'@divi/module': ['divi', 'module'],
			'@divi/module-library': ['divi', 'moduleLibrary'],
		},
		module: {
			rules: [jsRule],
		},
		resolve: {
			extensions: ['.js', '.jsx', '.json'],
		},
		output: {
			filename: 'tutor-lms-divi-5.js',
			path: path.resolve(__dirname, 'includes/div5modules/build'),
		},
	};
}

function cssConfig(compressed, isProduction) {
	const sourceMap = !compressed && !isProduction;

	return {
		name: compressed ? 'css-min' : 'css',
		mode: compressed ? 'production' : 'development',
		devtool: sourceMap ? 'source-map' : false,
		entry: {
			'tutor-divi-style': './assets/scss/frontend-main.scss',
			admin_notice: './assets/scss/backend-main.scss',
		},
		output: {
			path: path.resolve(__dirname, 'assets/css'),
			filename: '[name].js',
		},
		module: {
			rules: [
				{
					test: /\.scss$/,
					use: [
						MiniCssExtractPlugin.loader,
						{
							loader: 'css-loader',
							options: {
								url: false,
								sourceMap,
							},
						},
						{
							loader: 'sass-loader',
							options: {
								sourceMap,
								sassOptions: {
									style: compressed ? 'compressed' : 'expanded',
								},
							},
						},
					],
				},
			],
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: compressed ? '[name].min.css' : '[name].css',
			}),
			new RemoveEmptyScriptsPlugin(),
		],
	};
}

function configsForTarget(target, isProduction) {
	const d4 = [
		divi4BuilderConfig(isProduction),
		divi4FrontendConfig(isProduction),
	];
	const d5 = [
		divi5Config(isProduction),
		cssConfig(false, isProduction),
		cssConfig(true, isProduction),
	];

	if (target === 'd4') {
		return d4;
	}

	if (target === 'd5') {
		return d5;
	}

	return d4.concat(d5);
}

module.exports = (env, argv) => {
	const isProduction = process.env.NODE_ENV === 'production' || argv.mode === 'production';
	const target = env && env.target ? env.target : 'all';

	return configsForTarget(target, isProduction);
};
