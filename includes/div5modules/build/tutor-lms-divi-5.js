/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./includes/div5modules/course-about/index.jsx"
/*!*****************************************************!*\
  !*** ./includes/div5modules/course-about/index.jsx ***!
  \*****************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   courseAboutModule: () => (/* binding */ courseAboutModule)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _divi_rest__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @divi/rest */ \"@divi/rest\");\n/* harmony import */ var _divi_rest__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_divi_rest__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _divi_module__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @divi/module */ \"@divi/module\");\n/* harmony import */ var _divi_module__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_divi_module__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _module_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./module.json */ \"./includes/div5modules/course-about/module.json\");\n/* harmony import */ var _conversion_outline_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./conversion-outline.json */ \"./includes/div5modules/course-about/conversion-outline.json\");\n\n\n\n\n\nconst ModuleStyles = ({\n  attrs,\n  elements,\n  settings,\n  orderClass,\n  mode,\n  state,\n  noStyleTag\n}) => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_divi_module__WEBPACK_IMPORTED_MODULE_2__.StyleContainer, {\n  mode: mode,\n  state: state,\n  noStyleTag: noStyleTag\n}, elements.style({\n  attrName: 'module',\n  styleProps: {\n    disabledOn: {\n      disabledModuleVisibility: settings?.disabledModuleVisibility\n    }\n  }\n}), elements.style({\n  attrName: 'heading'\n}), elements.style({\n  attrName: 'aboutText'\n}));\nconst ModuleScriptData = ({\n  elements\n}) => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, elements.scriptData({\n  attrName: 'module'\n}));\nconst moduleClassnames = ({\n  classnamesInstance,\n  attrs\n}) => {\n  classnamesInstance.add((0,_divi_module__WEBPACK_IMPORTED_MODULE_2__.elementClassnames)({\n    attrs: attrs?.module?.decoration ?? {}\n  }));\n};\nconst CourseAboutEdit = ({\n  attrs,\n  id,\n  name,\n  elements\n}) => {\n  const courseId = attrs?.content?.advanced?.course?.desktop?.value ?? '';\n  const {\n    fetch,\n    response,\n    isLoading\n  } = (0,_divi_rest__WEBPACK_IMPORTED_MODULE_1__.useFetch)({});\n  const fetchAbortRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)();\n  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {\n    if (fetchAbortRef.current) {\n      fetchAbortRef.current.abort();\n    }\n    fetchAbortRef.current = new AbortController();\n    fetch({\n      restRoute: `/tutor-divi/v1/course-about?course=${encodeURIComponent(courseId)}`,\n      method: 'GET',\n      signal: fetchAbortRef.current.signal\n    }).catch(error => {\n      console.error(error);\n    });\n    return () => {\n      if (fetchAbortRef.current) {\n        fetchAbortRef.current.abort();\n      }\n    };\n  }, [courseId]);\n  const html = response?.html ?? '';\n  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_divi_module__WEBPACK_IMPORTED_MODULE_2__.ModuleContainer, {\n    attrs: attrs,\n    elements: elements,\n    id: id,\n    name: name,\n    scriptDataComponent: ModuleScriptData,\n    stylesComponent: ModuleStyles,\n    classnamesFunction: moduleClassnames\n  }, elements.styleComponents({\n    attrName: 'module'\n  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(\"div\", {\n    className: \"et_pb_module_inner\"\n  }, !isLoading && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(\"div\", {\n    dangerouslySetInnerHTML: {\n      __html: html\n    }\n  })));\n};\nconst courseAboutModule = {\n  metadata: _module_json__WEBPACK_IMPORTED_MODULE_3__,\n  conversionOutline: _conversion_outline_json__WEBPACK_IMPORTED_MODULE_4__,\n  renderers: {\n    edit: CourseAboutEdit\n  }\n};\n\n//# sourceURL=webpack://tutor-lms-divi-modules/./includes/div5modules/course-about/index.jsx?\n}");

/***/ },

/***/ "./includes/div5modules/course-title/index.jsx"
/*!*****************************************************!*\
  !*** ./includes/div5modules/course-title/index.jsx ***!
  \*****************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   courseTitleModule: () => (/* binding */ courseTitleModule)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _divi_rest__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @divi/rest */ \"@divi/rest\");\n/* harmony import */ var _divi_rest__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_divi_rest__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _divi_module__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @divi/module */ \"@divi/module\");\n/* harmony import */ var _divi_module__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_divi_module__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _module_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./module.json */ \"./includes/div5modules/course-title/module.json\");\n/* harmony import */ var _conversion_outline_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./conversion-outline.json */ \"./includes/div5modules/course-title/conversion-outline.json\");\n\n\n\n\n\nconst ModuleStyles = ({\n  attrs,\n  elements,\n  settings,\n  orderClass,\n  mode,\n  state,\n  noStyleTag\n}) => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_divi_module__WEBPACK_IMPORTED_MODULE_2__.StyleContainer, {\n  mode: mode,\n  state: state,\n  noStyleTag: noStyleTag\n}, elements.style({\n  attrName: 'module',\n  styleProps: {\n    disabledOn: {\n      disabledModuleVisibility: settings?.disabledModuleVisibility\n    }\n  }\n}), elements.style({\n  attrName: 'title'\n}));\nconst ModuleScriptData = ({\n  elements\n}) => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, elements.scriptData({\n  attrName: 'module'\n}));\nconst moduleClassnames = ({\n  classnamesInstance,\n  attrs\n}) => {\n  classnamesInstance.add((0,_divi_module__WEBPACK_IMPORTED_MODULE_2__.elementClassnames)({\n    attrs: attrs?.module?.decoration ?? {}\n  }));\n};\nconst CourseTitleEdit = ({\n  attrs,\n  id,\n  name,\n  elements\n}) => {\n  const courseId = attrs?.content?.advanced?.course?.desktop?.value ?? '';\n  const headingLevel = attrs?.title?.decoration?.font?.font?.desktop?.value?.headingLevel ?? 'h1';\n  const Header = headingLevel;\n  const {\n    fetch,\n    response,\n    isLoading\n  } = (0,_divi_rest__WEBPACK_IMPORTED_MODULE_1__.useFetch)({});\n  const fetchAbortRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)();\n  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {\n    if (fetchAbortRef.current) {\n      fetchAbortRef.current.abort();\n    }\n    fetchAbortRef.current = new AbortController();\n    fetch({\n      restRoute: `/tutor-divi/v1/course-title?course=${encodeURIComponent(courseId)}`,\n      method: 'GET',\n      signal: fetchAbortRef.current.signal\n    }).catch(error => {\n      console.error(error);\n    });\n    return () => {\n      if (fetchAbortRef.current) {\n        fetchAbortRef.current.abort();\n      }\n    };\n  }, [courseId]);\n  const title = response?.title ?? '';\n  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_divi_module__WEBPACK_IMPORTED_MODULE_2__.ModuleContainer, {\n    attrs: attrs,\n    elements: elements,\n    id: id,\n    name: name,\n    scriptDataComponent: ModuleScriptData,\n    stylesComponent: ModuleStyles,\n    classnamesFunction: moduleClassnames\n  }, elements.styleComponents({\n    attrName: 'module'\n  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(\"div\", {\n    className: \"et_pb_module_inner\"\n  }, !isLoading && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(Header, {\n    className: \"dtlms-course-title tutor-course-details-title tutor-fs-4 tutor-fw-bold tutor-color-black tutor-mt-12 tutor-mb-0\",\n    dangerouslySetInnerHTML: {\n      __html: title\n    }\n  })));\n};\nconst courseTitleModule = {\n  metadata: _module_json__WEBPACK_IMPORTED_MODULE_3__,\n  conversionOutline: _conversion_outline_json__WEBPACK_IMPORTED_MODULE_4__,\n  renderers: {\n    edit: CourseTitleEdit\n  }\n};\n\n//# sourceURL=webpack://tutor-lms-divi-modules/./includes/div5modules/course-title/index.jsx?\n}");

/***/ },

/***/ "./includes/div5modules/index.jsx"
/*!****************************************!*\
  !*** ./includes/div5modules/index.jsx ***!
  \****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/hooks */ \"@wordpress/hooks\");\n/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _divi_module_library__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @divi/module-library */ \"@divi/module-library\");\n/* harmony import */ var _divi_module_library__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_divi_module_library__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _course_title_index_jsx__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./course-title/index.jsx */ \"./includes/div5modules/course-title/index.jsx\");\n/* harmony import */ var _course_about_index_jsx__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./course-about/index.jsx */ \"./includes/div5modules/course-about/index.jsx\");\n\n\n\n\n(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__.addAction)('divi.moduleLibrary.registerModuleLibraryStore.after', 'tutorLms.divi5Modules', () => {\n  (0,_divi_module_library__WEBPACK_IMPORTED_MODULE_1__.registerModule)(_course_title_index_jsx__WEBPACK_IMPORTED_MODULE_2__.courseTitleModule.metadata, {\n    conversionOutline: _course_title_index_jsx__WEBPACK_IMPORTED_MODULE_2__.courseTitleModule.conversionOutline,\n    renderers: _course_title_index_jsx__WEBPACK_IMPORTED_MODULE_2__.courseTitleModule.renderers\n  });\n  (0,_divi_module_library__WEBPACK_IMPORTED_MODULE_1__.registerModule)(_course_about_index_jsx__WEBPACK_IMPORTED_MODULE_3__.courseAboutModule.metadata, {\n    conversionOutline: _course_about_index_jsx__WEBPACK_IMPORTED_MODULE_3__.courseAboutModule.conversionOutline,\n    renderers: _course_about_index_jsx__WEBPACK_IMPORTED_MODULE_3__.courseAboutModule.renderers\n  });\n});\n\n//# sourceURL=webpack://tutor-lms-divi-modules/./includes/div5modules/index.jsx?\n}");

/***/ },

/***/ "@divi/module"
/*!**********************************!*\
  !*** external ["divi","module"] ***!
  \**********************************/
(module) {

module.exports = divi.module;

/***/ },

/***/ "@divi/module-library"
/*!*****************************************!*\
  !*** external ["divi","moduleLibrary"] ***!
  \*****************************************/
(module) {

module.exports = divi.moduleLibrary;

/***/ },

/***/ "@divi/rest"
/*!********************************!*\
  !*** external ["divi","rest"] ***!
  \********************************/
(module) {

module.exports = divi.rest;

/***/ },

/***/ "react"
/*!***********************************!*\
  !*** external ["vendor","React"] ***!
  \***********************************/
(module) {

module.exports = vendor.React;

/***/ },

/***/ "@wordpress/hooks"
/*!****************************************!*\
  !*** external ["vendor","wp","hooks"] ***!
  \****************************************/
(module) {

module.exports = vendor.wp.hooks;

/***/ },

/***/ "./includes/div5modules/course-about/conversion-outline.json"
/*!*******************************************************************!*\
  !*** ./includes/div5modules/course-about/conversion-outline.json ***!
  \*******************************************************************/
(module) {

eval("{module.exports = /*#__PURE__*/JSON.parse('{\"advanced\":{\"fonts\":{\"heading\":\"heading.decoration.font\",\"about_text\":\"aboutText.decoration.font\"},\"admin_label\":\"module.meta.adminLabel\",\"animation\":\"module.decoration.animation\",\"box_shadow\":{\"default\":\"module.decoration.boxShadow\"},\"disabled_on\":\"module.decoration.disabledOn\",\"filters\":{\"default\":\"module.decoration.filters\"},\"margin_padding\":\"module.decoration.spacing\",\"module\":\"module.advanced.htmlAttributes\",\"overflow\":\"module.decoration.overflow\",\"position_fields\":\"module.decoration.position\",\"scroll\":\"module.decoration.scroll\",\"sticky\":\"module.decoration.sticky\",\"transform\":\"module.decoration.transform\",\"transition\":\"module.decoration.transition\",\"z_index\":\"module.decoration.zIndex\"},\"css\":{\"free_form\":\"css.*.freeForm\",\"before\":\"css.*.before\",\"main_element\":\"css.*.mainElement\",\"after\":\"css.*.after\"},\"module\":{\"course\":\"content.advanced.course.*\"}}');\n\n//# sourceURL=webpack://tutor-lms-divi-modules/./includes/div5modules/course-about/conversion-outline.json?\n}");

/***/ },

/***/ "./includes/div5modules/course-about/module.json"
/*!*******************************************************!*\
  !*** ./includes/div5modules/course-about/module.json ***!
  \*******************************************************/
(module) {

eval("{module.exports = /*#__PURE__*/JSON.parse('{\"name\":\"tutor-lms/course-about\",\"d4Shortcode\":\"tutor_course_about\",\"title\":\"Tutor Course About\",\"titles\":\"Tutor Course About\",\"category\":\"module\",\"moduleClassName\":\"et_pb_tutor_course_about\",\"moduleOrderClassName\":\"et_pb_tutor_course_about\",\"attributes\":{\"module\":{\"type\":\"object\",\"selector\":\"{{selector}}\",\"default\":{\"meta\":{\"adminLabel\":{\"desktop\":{\"value\":\"Tutor Course About\"}}}},\"settings\":{\"meta\":{\"adminLabel\":{}},\"advanced\":{\"html\":{}},\"decoration\":{\"boxShadow\":{},\"filters\":{},\"transform\":{},\"animation\":{},\"spacing\":{},\"overflow\":{},\"disabledOn\":{},\"transition\":{},\"position\":{},\"zIndex\":{},\"scroll\":{},\"sticky\":{}}}},\"heading\":{\"type\":\"object\",\"selector\":\"{{selector}} .tutor-course-details-content h2\",\"settings\":{\"decoration\":{\"font\":{\"groupType\":\"group-item\",\"item\":{\"groupSlug\":\"designHeading\",\"priority\":10,\"render\":true,\"component\":{\"type\":\"group\",\"name\":\"divi/font\",\"props\":{\"grouped\":false,\"groupLabel\":\"Heading\",\"fieldLabel\":\"Heading\",\"fields\":{\"headingLevel\":{\"render\":false}}}}}}}},\"styleProps\":{\"font\":{\"selector\":\"{{selector}} .tutor-course-details-content h2\"}}},\"aboutText\":{\"type\":\"object\",\"selector\":\"{{selector}} .dtlms-course-about-text\",\"settings\":{\"decoration\":{\"font\":{\"groupType\":\"group-item\",\"item\":{\"groupSlug\":\"designAboutText\",\"priority\":10,\"render\":true,\"component\":{\"type\":\"group\",\"name\":\"divi/font\",\"props\":{\"grouped\":false,\"groupLabel\":\"Paragraph\"}}}}}},\"styleProps\":{\"font\":{\"selector\":\"{{selector}} .dtlms-course-about-text\"}}},\"content\":{\"type\":\"object\",\"settings\":{\"advanced\":{\"course\":{\"groupType\":\"group-item\",\"item\":{\"groupSlug\":\"contentMainContent\",\"attrName\":\"content.advanced.course\",\"label\":\"Course\",\"description\":\"Here you can select the Course.\",\"priority\":10,\"render\":true,\"features\":{\"sticky\":false,\"hover\":false,\"responsive\":false},\"component\":{\"type\":\"field\",\"name\":\"divi/select\",\"props\":{\"options\":{}}}}}}}}},\"customCssFields\":{},\"settings\":{\"content\":\"auto\",\"design\":\"auto\",\"advanced\":\"auto\",\"groups\":{\"contentMainContent\":{\"panel\":\"content\",\"priority\":10,\"groupName\":\"contentMainContent\",\"multiElements\":true,\"component\":{\"name\":\"divi/composite\",\"props\":{\"groupLabel\":\"Content\"}}},\"designHeading\":{\"panel\":\"design\",\"priority\":10,\"groupName\":\"designHeading\",\"multiElements\":true,\"component\":{\"name\":\"divi/composite\",\"props\":{\"clipboardCategory\":\"style\",\"groupLabel\":\"Heading\",\"presetGroup\":\"divi/font\",\"dynamicSubgroupHost\":true}}},\"designAboutText\":{\"panel\":\"design\",\"priority\":20,\"groupName\":\"designAboutText\",\"multiElements\":true,\"component\":{\"name\":\"divi/composite\",\"props\":{\"clipboardCategory\":\"style\",\"groupLabel\":\"Paragraph\",\"presetGroup\":\"divi/font\",\"dynamicSubgroupHost\":true}}}}}}');\n\n//# sourceURL=webpack://tutor-lms-divi-modules/./includes/div5modules/course-about/module.json?\n}");

/***/ },

/***/ "./includes/div5modules/course-title/conversion-outline.json"
/*!*******************************************************************!*\
  !*** ./includes/div5modules/course-title/conversion-outline.json ***!
  \*******************************************************************/
(module) {

eval("{module.exports = /*#__PURE__*/JSON.parse('{\"advanced\":{\"fonts\":{\"header\":\"title.decoration.font\"},\"admin_label\":\"module.meta.adminLabel\",\"disabled_on\":\"module.decoration.disabledOn\",\"margin_padding\":\"module.decoration.spacing\",\"module\":\"module.advanced.htmlAttributes\",\"overflow\":\"module.decoration.overflow\",\"position_fields\":\"module.decoration.position\",\"scroll\":\"module.decoration.scroll\",\"sticky\":\"module.decoration.sticky\",\"transition\":\"module.decoration.transition\",\"z_index\":\"module.decoration.zIndex\"},\"css\":{\"free_form\":\"css.*.freeForm\",\"before\":\"css.*.before\",\"main_element\":\"css.*.mainElement\",\"after\":\"css.*.after\"},\"module\":{\"course\":\"content.advanced.course.*\",\"header_level\":\"title.decoration.font.font.*.headingLevel\"}}');\n\n//# sourceURL=webpack://tutor-lms-divi-modules/./includes/div5modules/course-title/conversion-outline.json?\n}");

/***/ },

/***/ "./includes/div5modules/course-title/module.json"
/*!*******************************************************!*\
  !*** ./includes/div5modules/course-title/module.json ***!
  \*******************************************************/
(module) {

eval("{module.exports = /*#__PURE__*/JSON.parse('{\"name\":\"tutor-lms/course-title\",\"d4Shortcode\":\"tutor_course_title\",\"title\":\"Tutor Course Title\",\"titles\":\"Tutor Course Title\",\"category\":\"module\",\"moduleClassName\":\"et_pb_tutor_course_title\",\"moduleOrderClassName\":\"et_pb_tutor_course_title\",\"attributes\":{\"module\":{\"type\":\"object\",\"selector\":\"{{selector}}\",\"default\":{\"meta\":{\"adminLabel\":{\"desktop\":{\"value\":\"Tutor Course Title\"}}}},\"settings\":{\"meta\":{\"adminLabel\":{}},\"advanced\":{\"html\":{}},\"decoration\":{\"spacing\":{},\"overflow\":{},\"disabledOn\":{},\"transition\":{},\"position\":{},\"zIndex\":{},\"scroll\":{},\"sticky\":{}}}},\"title\":{\"type\":\"object\",\"selector\":\"{{selector}} h1, {{selector}} h2, {{selector}} h3, {{selector}} h4, {{selector}} h5, {{selector}} h6\",\"default\":{\"decoration\":{\"font\":{\"font\":{\"desktop\":{\"value\":{\"headingLevel\":\"h1\"}}}}}},\"settings\":{\"decoration\":{\"font\":{\"groupType\":\"group-item\",\"item\":{\"groupSlug\":\"designTitleText\",\"priority\":10,\"render\":true,\"component\":{\"type\":\"group\",\"name\":\"divi/font\",\"props\":{\"grouped\":false,\"groupLabel\":\"Title Text\",\"fieldLabel\":\"Title\",\"fields\":{\"headingLevel\":{\"render\":true}}}}}}}},\"styleProps\":{\"font\":{\"selector\":\"{{selector}} h1, {{selector}} h2, {{selector}} h3, {{selector}} h4, {{selector}} h5, {{selector}} h6\"}}},\"content\":{\"type\":\"object\",\"settings\":{\"advanced\":{\"course\":{\"groupType\":\"group-item\",\"item\":{\"groupSlug\":\"contentMainContent\",\"attrName\":\"content.advanced.course\",\"label\":\"Course\",\"description\":\"Here you can select the Course.\",\"priority\":10,\"render\":true,\"features\":{\"sticky\":false,\"hover\":false,\"responsive\":false},\"component\":{\"type\":\"field\",\"name\":\"divi/select\",\"props\":{\"options\":{}}}}}}}}},\"customCssFields\":{},\"settings\":{\"content\":\"auto\",\"design\":\"auto\",\"advanced\":\"auto\",\"groups\":{\"contentMainContent\":{\"panel\":\"content\",\"priority\":10,\"groupName\":\"contentMainContent\",\"multiElements\":true,\"component\":{\"name\":\"divi/composite\",\"props\":{\"groupLabel\":\"Content\"}}},\"designTitleText\":{\"panel\":\"design\",\"priority\":49,\"groupName\":\"designTitleText\",\"multiElements\":true,\"component\":{\"name\":\"divi/composite\",\"props\":{\"clipboardCategory\":\"style\",\"groupLabel\":\"Title Text\",\"presetGroup\":\"divi/font\",\"dynamicSubgroupHost\":true}}}}}}');\n\n//# sourceURL=webpack://tutor-lms-divi-modules/./includes/div5modules/course-title/module.json?\n}");

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	const __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		const cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		const module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		if (!(moduleId in __webpack_modules__)) {
/******/ 			delete __webpack_module_cache__[moduleId];
/******/ 			const e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = (module) => {
/******/ 		const getter = module && module.__esModule ?
/******/ 			() => (module['default']) :
/******/ 			() => (module);
/******/ 		__webpack_require__.d(getter, { a: getter });
/******/ 		return getter;
/******/ 	};
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	// define getter/value functions for harmony exports
/******/ 	__webpack_require__.d = (exports, definition) => {
/******/ 		for(var key in definition) {
/******/ 			if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 				Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 			}
/******/ 		}
/******/ 	};
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	__webpack_require__.o = (obj, prop) => (Object.hasOwn(obj, prop));
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = (exports) => {
/******/ 		Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	let __webpack_exports__ = __webpack_require__("./includes/div5modules/index.jsx");
/******/ 	
/******/ })()
;