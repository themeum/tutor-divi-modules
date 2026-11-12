import React, { useEffect, useRef } from 'react';
import { useFetch } from '@divi/rest';
import {
  CommonStyle,
  ModuleContainer,
  StyleContainer,
  elementClassnames,
} from '@divi/module';
import metadata from './module.json';
import conversionOutline from './conversion-outline.json';

const desktopValue = (attr, fallback) => {
  const value = attr?.desktop?.value;

  if (Array.isArray(value)) {
    return value;
  }

  if (value === undefined || value === null || value === '') {
    return fallback;
  }

  return value;
};

const includesParam = (value) => {
  if (Array.isArray(value)) {
    return value.join(',');
  }

  if (value && typeof value === 'object') {
    return Object.keys(value)
      .filter((key) => value[key] === 'on' || value[key] === true)
      .join(',');
  }

  return value || '';
};

const hiddenWhenOff = ({ attrValue }) => (
  attrValue === 'off' ? 'display: none !important;' : ''
);

const dotsJustification = (alignment) => {
  if (alignment === 'left') {
    return 'flex-start';
  }

  if (alignment === 'right') {
    return 'flex-end';
  }

  return 'center';
};

const withCheckboxOptions = (moduleMetadata) => {
  const data = typeof window !== 'undefined' ? (window.TutorLmsDivi5VisualBuilderData || {}) : {};
  const next = JSON.parse(JSON.stringify(moduleMetadata));
  const advanced = next.attributes.content.settings.advanced;

  advanced.categoryIncludes.item.component.props.options = data.categories || [];
  advanced.authorIncludes.item.component.props.options = data.authors || [];

  return next;
};

const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}) => (
  <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
    {elements.style({
      attrName: 'module',
      styleProps: {
        disabledOn: {
          disabledModuleVisibility: settings?.disabledModuleVisibility,
        },
      },
    })}
    {elements.style({
      attrName: 'title',
    })}
    {elements.style({
      attrName: 'meta',
    })}
    {elements.style({
      attrName: 'category',
    })}
    <CommonStyle
      selector={`${orderClass} .tutor-course-thumbnail`}
      attr={attrs?.content?.advanced?.showImage ?? { desktop: { value: 'on' } }}
      declarationFunction={hiddenWhenOff}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-course-ratings, ${orderClass} .tutor-ratings`}
      attr={attrs?.content?.advanced?.rating ?? { desktop: { value: 'on' } }}
      declarationFunction={hiddenWhenOff}
    />
    <CommonStyle
      selector={`${orderClass} .dtlms-course-duration-meta`}
      attr={attrs?.content?.advanced?.metaData ?? { desktop: { value: 'off' } }}
      declarationFunction={hiddenWhenOff}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-course-card, ${orderClass} .tutor-card`}
      attr={attrs?.card?.advanced?.backgroundColor ?? {}}
      declarationFunction={({ attrValue }) => (
        attrValue ? `background-color: ${attrValue};` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .slick-slide`}
      attr={attrs?.card?.advanced?.gap ?? { desktop: { value: '15px' } }}
      declarationFunction={({ attrValue }) => (
        attrValue ? `margin-left: ${attrValue} !important; margin-right: ${attrValue} !important;` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-card-body`}
      attr={attrs?.card?.advanced?.bodyPadding ?? { desktop: { value: '18px' } }}
      declarationFunction={({ attrValue }) => (
        attrValue ? `padding: ${attrValue} !important;` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-ratings-stars span`}
      attr={attrs?.rating?.advanced?.starColor ?? {}}
      declarationFunction={({ attrValue }) => (
        attrValue ? `color: ${attrValue};` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-ratings-stars span`}
      attr={attrs?.rating?.advanced?.starSize ?? { desktop: { value: '18px' } }}
      declarationFunction={({ attrValue }) => (
        attrValue ? `font-size: ${attrValue};` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-ratings-stars span`}
      attr={attrs?.rating?.advanced?.starGap ?? {}}
      declarationFunction={({ attrValue }) => (
        attrValue ? `margin-left: ${attrValue} !important; margin-right: ${attrValue} !important;` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .slick-dots`}
      attr={attrs?.content?.advanced?.dotsAlignment ?? { desktop: { value: 'center' } }}
      declarationFunction={({ attrValue }) => (
        `display: flex !important; bottom: -50px !important; justify-content: ${dotsJustification(attrValue)}; column-gap: 5px;`
      )}
    />
    <CommonStyle
      selector={`#et-fb-app ${orderClass} .tutor-divi-carousel-main-wrap`}
      attr={attrs?.content?.advanced?.arrows ?? { desktop: { value: 'on' } }}
      declarationFunction={() => 'position: relative; padding: 0 36px 48px;'}
    />
    <CommonStyle
      selector={`#et-fb-app ${orderClass} .slick-prev`}
      attr={attrs?.content?.advanced?.arrows ?? { desktop: { value: 'on' } }}
      declarationFunction={() => 'left: 6px; z-index: 2;'}
    />
    <CommonStyle
      selector={`#et-fb-app ${orderClass} .slick-next`}
      attr={attrs?.content?.advanced?.arrows ?? { desktop: { value: 'on' } }}
      declarationFunction={() => 'right: 6px; z-index: 2;'}
    />
    <CommonStyle
      selector={`#et-fb-app ${orderClass} .slick-prev:before, #et-fb-app ${orderClass} .slick-next:before`}
      attr={attrs?.content?.advanced?.arrows ?? { desktop: { value: 'on' } }}
      declarationFunction={() => 'color: #2c3e50;'}
    />
    <CommonStyle
      selector={`#et-fb-app ${orderClass} .slick-dots`}
      attr={attrs?.content?.advanced?.dots ?? { desktop: { value: 'on' } }}
      declarationFunction={() => 'bottom: 12px !important;'}
    />
    <CommonStyle
      selector={`${orderClass} .slick-track`}
      attr={attrs?.content?.advanced?.skin ?? { desktop: { value: 'classic' } }}
      declarationFunction={({ attrValue }) => (
        attrValue === 'classic' || attrValue === 'card'
          ? 'display: flex; flex-direction: row; flex-wrap: nowrap; align-items: stretch;'
          : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-course-card`}
      attr={attrs?.content?.advanced?.skin ?? { desktop: { value: 'classic' } }}
      declarationFunction={({ attrValue }) => (
        attrValue === 'classic' || attrValue === 'card'
          ? 'display: flex; flex-direction: column; justify-content: space-between; height: 100%;'
          : ''
      )}
    />
  </StyleContainer>
);

const ModuleScriptData = ({ elements }) => (
  <React.Fragment>
    {elements.scriptData({
      attrName: 'module',
    })}
  </React.Fragment>
);

const moduleClassnames = ({ classnamesInstance, attrs }) => {
  classnamesInstance.add(
    elementClassnames({
      attrs: attrs?.module?.decoration ?? {},
    }),
  );
};

const appendStylesheet = (href) => {
  if (!href || document.querySelector(`link[href="${href}"]`)) {
    return;
  }

  const link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = href;
  document.head.appendChild(link);
};

/**
 * Load Slick into the Visual Builder app frame when the carousel module is rendered
 * and the frame did not receive it from PHP.
 */
const ensureCourseCarouselSlick = () => new Promise((resolve) => {
  const jquery = window.jQuery;

  if (jquery?.fn?.slick) {
    resolve();
    return;
  }

  const assets = window.TutorLmsDivi5VisualBuilderData?.slick || {};

  if (!assets.script) {
    resolve();
    return;
  }

  appendStylesheet(assets.style);
  appendStylesheet(assets.theme);

  const finish = () => resolve();
  const existing = document.querySelector(`script[src="${assets.script}"]`);

  if (existing) {
    if (window.jQuery?.fn?.slick) {
      finish();
      return;
    }

    existing.addEventListener('load', finish, { once: true });
    existing.addEventListener('error', finish, { once: true });
    return;
  }

  const script = document.createElement('script');
  script.src = assets.script;
  script.onload = finish;
  script.onerror = finish;
  document.body.appendChild(script);
});

const CourseCarouselEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const previewRef = useRef(null);
  const skin = desktopValue(content.skin, 'classic');
  const slidesToShow = desktopValue(content.slidesToShow, '3');
  const hoverAnimation = desktopValue(content.hoverAnimation, 'on');
  const showImage = desktopValue(content.showImage, 'on');
  const imageSize = desktopValue(content.imageSize, 'medium_large');
  const metaData = desktopValue(content.metaData, 'off');
  const rating = desktopValue(content.rating, 'on');
  const avatar = desktopValue(content.avatar, 'on');
  const author = desktopValue(content.author, 'on');
  const difficultyLabel = desktopValue(content.difficultyLabel, 'off');
  const wishList = desktopValue(content.wishList, 'on');
  const showCategory = desktopValue(content.showCategory, 'off');
  const footer = desktopValue(content.footer, 'on');
  const orderBy = desktopValue(content.orderBy, 'date');
  const order = desktopValue(content.order, 'DESC');
  const limit = desktopValue(content.limit, '5');
  const categoryIncludes = includesParam(desktopValue(content.categoryIncludes, []));
  const authorIncludes = includesParam(desktopValue(content.authorIncludes, []));
  const arrows = desktopValue(content.arrows, 'on');
  const dots = desktopValue(content.dots, 'on');
  const transition = desktopValue(content.transition, '600');
  const centerSlides = desktopValue(content.centerSlides, 'off');
  const smoothScrolling = desktopValue(content.smoothScrolling, 'on');
  const autoplay = desktopValue(content.autoplay, 'on');
  const autoplaySpeed = desktopValue(content.autoplaySpeed, '5000');
  const infiniteLoop = desktopValue(content.infiniteLoop, 'on');
  const pauseOnHover = desktopValue(content.pauseOnHover, 'on');
  const dotsAlignment = desktopValue(content.dotsAlignment, 'center');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      skin,
      slides_to_show: String(slidesToShow),
      hover_animation: hoverAnimation,
      show_image: showImage,
      image_size: imageSize,
      meta_data: metaData,
      rating,
      avatar,
      author,
      difficulty_label: difficultyLabel,
      wish_list: wishList,
      show_category: showCategory,
      footer,
      order_by: orderBy,
      order,
      limit: String(limit),
      category_includes: categoryIncludes,
      author_includes: authorIncludes,
      arrows,
      dots,
      transition: String(transition),
      center_slides: centerSlides,
      smooth_scrolling: smoothScrolling,
      autoplay,
      autoplay_speed: String(autoplaySpeed),
      infinite_loop: infiniteLoop,
      pause_on_hover: pauseOnHover,
      dots_alignment: dotsAlignment,
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-carousel?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [
    skin,
    slidesToShow,
    hoverAnimation,
    showImage,
    imageSize,
    metaData,
    rating,
    avatar,
    author,
    difficultyLabel,
    wishList,
    showCategory,
    footer,
    orderBy,
    order,
    limit,
    categoryIncludes,
    authorIncludes,
    arrows,
    dots,
    transition,
    centerSlides,
    smoothScrolling,
    autoplay,
    autoplaySpeed,
    infiniteLoop,
    pauseOnHover,
    dotsAlignment,
  ]);

  const html = response?.html ?? '';

  useEffect(() => {
    if (!html) {
      return undefined;
    }

    let attempts = 0;
    let timer = 0;
    let cancelled = false;

    const startCarousel = () => {
      if (cancelled) {
        return;
      }

      if (typeof window.dtlmsInitCourseCarousels === 'function') {
        window.dtlmsInitCourseCarousels();
      }

      document.dispatchEvent(new CustomEvent('dtlms-course-carousel-init'));

      const pending = previewRef.current?.querySelector('.tutor-divi-slick-responsive:not(.slick-initialized)');
      attempts += 1;

      if (pending && attempts < 20) {
        timer = window.setTimeout(startCarousel, 150);
      }
    };

    const frame = window.requestAnimationFrame(() => {
      ensureCourseCarouselSlick().then(startCarousel);
    });

    return () => {
      cancelled = true;
      window.cancelAnimationFrame(frame);
      window.clearTimeout(timer);
    };
  }, [html]);

  return (
    <ModuleContainer
      attrs={attrs}
      elements={elements}
      id={id}
      name={name}
      scriptDataComponent={ModuleScriptData}
      stylesComponent={ModuleStyles}
      classnamesFunction={moduleClassnames}
    >
      {elements.styleComponents({
        attrName: 'module',
      })}
      <div className="et_pb_module_inner" ref={previewRef}>
        {!isLoading && (
          <div dangerouslySetInnerHTML={{ __html: html }} />
        )}
      </div>
    </ModuleContainer>
  );
};

export const courseCarouselModule = {
  metadata: withCheckboxOptions(metadata),
  conversionOutline,
  renderers: {
    edit: CourseCarouselEdit,
  },
};
