import React, { useEffect } from 'react';
import { select } from '@divi/data';
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

  if (value === undefined || value === null || value === '') {
    return fallback;
  }

  return value;
};

const cssLength = (value) => {
  const length = `${value ?? ''}`.trim();

  if (!length) {
    return '';
  }

  return /^-?\d+(\.\d+)?$/.test(length) ? `${length}px` : length;
};

const breakpointValue = (attr, breakpoint, fallback) => {
  const current = attr?.[breakpoint]?.value;
  if (current !== undefined && current !== null && current !== '') {
    return current;
  }

  return desktopValue(attr, fallback);
};

const editingPostId = () => {
  try {
    const postId = select('divi/settings')?.getSetting?.(['post', 'id']);

    return postId ? String(postId) : '';
  } catch (error) {
    return '';
  }
};

const fixedStyle = (selector, declaration) => (
  <CommonStyle
    selector={selector}
    attr={{ desktop: { value: '1' } }}
    declarationFunction={() => declaration}
  />
);

const lengthStyle = (selector, attr, property, important = false) => (
  <CommonStyle
    selector={selector}
    attr={attr}
    declarationFunction={({ attrValue }) => {
      const length = cssLength(attrValue);

      return length ? `${property}: ${length}${important ? ' !important' : ''};` : '';
    }}
  />
);

const colorStyle = (selector, attr, property = 'color', important = false) => (
  <CommonStyle
    selector={selector}
    attr={attr || {}}
    declarationFunction={({ attrValue }) => (
      attrValue ? `${property}: ${attrValue}${important ? ' !important' : ''};` : ''
    )}
  />
);

const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}) => {
  const curriculum = `${orderClass} .dtlms-course-curriculum`;
  const benefits = `${orderClass} .tutor-course-details-widget`;
  const benefitsList = `${orderClass} .tutor-course-details-widget-list`;
  const benefitsItem = `${benefitsList} li`;
  const benefitsIcon = `${benefitsItem} .et-pb-icon`;
  const nav = `${orderClass} .tutor-nav`;
  const topicHeader = `${curriculum} .tutor-accordion-item-header`;
  const topicItem = `${curriculum} .tutor-accordion-item`;
  const lessonIcon = `${orderClass} .tutor-accordion-item .tutor-course-content-list-item-icon, ${orderClass} .tutor-accordion-item .tutor-course-content-list-item-status`;
  const lessonIconHover = `${orderClass} .tutor-accordion-item .tutor-course-content-list-item-icon:hover, ${orderClass} .tutor-accordion-item .tutor-course-content-list-item-status:hover`;
  const lessonItem = `${orderClass} .tutor-accordion-item .tutor-course-content-list-item`;
  const lessonInfo = `${orderClass} .tutor-accordion-item .tutor-course-content-list-item-duration`;
  const reviews = `${orderClass} #tutor-course-details-tab-reviews`;
  const ratingBars = `${orderClass} .tutor-review-summary-ratings`;
  const content = attrs?.content?.advanced ?? {};
  const layoutAttr = content.layout ?? { desktop: { value: 'flex' } };
  const spaceAttr = attrs?.benefitsList?.advanced?.spaceBetween ?? { desktop: { value: '10px' } };
  const styleNames = [
    'about',
    'aboutHeading',
    'aboutText',
    'courseTabs',
    'benefits',
    'benefitsTitle',
    'benefitsList',
    'benefitsText',
    'benefitsIcon',
    'curriculumHeader',
    'topics',
    'topicTitle',
    'lesson',
    'reviewSectionTitle',
    'reviewAvg',
    'reviewAvgText',
    'reviewAvgStar',
    'ratingBar',
    'reviewAuthor',
    'reviewTime',
    'reviewComment',
    'reviewListStar',
    'reviewSummary',
    'review',
    'reviewAvatar',
    'reviewCard',
  ];

  return (
    <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
      {fixedStyle(benefits, 'display: flex; flex-direction: column;')}
      {fixedStyle(benefitsList, 'list-style: none; padding: 0; margin: 0;')}
      {fixedStyle(benefitsItem, 'list-style: none; border-style: solid;')}
      {fixedStyle(nav, 'display: flex !important;')}
      {fixedStyle(`${curriculum} .tutor-is-sticky`, 'top: 32px !important; position: sticky !important; backdrop-filter: blur(14px) !important; z-index: 1063 !important;')}
      {fixedStyle(`${topicItem} .tutor-course-content-list-item-title a`, 'color: inherit !important;')}
      {fixedStyle(`${topicItem} .tutor-course-content-list-item-icon`, 'margin-right: 12px !important;')}
      {fixedStyle(`${topicItem} .tutor-course-content-list-item-status`, 'margin-left: 20px !important;')}
      {fixedStyle(topicHeader, 'transition: background-color 300ms ease-in !important;')}
      {fixedStyle(topicItem, 'border: 1px solid #DCE4E6;')}
      {fixedStyle(`${curriculum} .tutor-course-title`, 'display: flex; column-gap: 10px; align-items: center !important;')}
      {fixedStyle(`${curriculum} .tutor-course-title h4`, 'padding: 0; margin: 0;')}
      {fixedStyle(`${curriculum} ul.tutor-courses-lession-list`, 'padding: 0 !important;')}
      {fixedStyle(`${reviews} .tutor-reviews .tutor-review-list-item .tutor-col-lg-3, ${reviews} .tutor-reviews .tutor-review-list-item .tutor-col-lg-9`, 'padding-left: 12px !important; padding-right: 12px !important;')}
      {fixedStyle(`${reviews} .tutor-ratings-stars span`, 'margin-left: 3px !important; margin-right: 3px !important;')}
      {fixedStyle(`${reviews} .tutor-review-summary .tutor-col-lg-auto, ${reviews} .tutor-review-summary .tutor-col-lg`, 'padding-left: 24px !important; padding-right: 24px !important;')}
      {fixedStyle(`${reviews} .tutor-review-summary .tutor-review-summary-average-rating`, 'margin-bottom: 20px !important;')}
      {elements.style({
        attrName: 'module',
        styleProps: {
          disabledOn: {
            disabledModuleVisibility: settings?.disabledModuleVisibility,
          },
        },
      })}
      {styleNames.map((attrName) => (
        <React.Fragment key={attrName}>
          {elements.style({ attrName })}
        </React.Fragment>
      ))}
      {lengthStyle(benefits, attrs?.benefitsTitle?.advanced?.gap ?? { desktop: { value: '10px' } }, 'row-gap')}
      <CommonStyle
        selector={benefitsList}
        attr={layoutAttr}
        declarationFunction={({ attrValue }) => (
          attrValue === 'flex'
            ? 'display: flex !important; flex-wrap: wrap;'
            : `display: ${attrValue || 'inline'} !important;`
        )}
      />
      <CommonStyle
        selector={benefits}
        attr={content.alignment ?? { desktop: { value: 'left' } }}
        declarationFunction={({ attrValue }) => (attrValue ? `text-align: ${attrValue} !important;` : '')}
      />
      <CommonStyle
        selector={benefitsList}
        attr={spaceAttr}
        declarationFunction={({ attrValue, breakpoint }) => {
          const space = cssLength(attrValue);
          const layout = breakpointValue(layoutAttr, breakpoint, 'flex');

          return space && layout === 'flex' ? `column-gap: ${space};` : '';
        }}
      />
      <CommonStyle
        selector={`${benefitsItem}:not(:last-child)`}
        attr={spaceAttr}
        declarationFunction={({ attrValue, breakpoint }) => {
          const space = cssLength(attrValue);
          const layout = breakpointValue(layoutAttr, breakpoint, 'flex');

          if (!space || layout === 'flex') {
            return '';
          }

          const property = layout === 'list' ? 'margin-bottom' : 'margin-right';

          return `${property}: ${space} !important;`;
        }}
      />
      {lengthStyle(`${benefitsItem} .list-item`, attrs?.benefitsText?.advanced?.indent ?? { desktop: { value: '7px' } }, 'padding-left', true)}
      {colorStyle(benefitsIcon, attrs?.benefitsIcon?.advanced?.color ?? { desktop: { value: '#757c8e' } }, 'color', true)}
      {lengthStyle(benefitsIcon, attrs?.benefitsIcon?.advanced?.size ?? { desktop: { value: '0.75rem' } }, 'font-size', true)}
      <CommonStyle
        selector={benefitsIcon}
        attr={content.icon ?? {}}
        declarationFunction={({ attrValue }) => {
          if (!attrValue || typeof attrValue !== 'object' || !attrValue.unicode) {
            return '';
          }

          const family = attrValue.type === 'fa' ? 'FontAwesome' : 'ETmodules';
          const weight = attrValue.weight ? ` font-weight: ${attrValue.weight};` : '';

          return `font-family: '${family}' !important;${weight}`;
        }}
      />
      {lengthStyle(nav, attrs?.courseTabs?.advanced?.gap ?? {}, 'column-gap', true)}
      {lengthStyle(`${topicHeader}::after`, attrs?.topics?.advanced?.iconSize ?? { desktop: { value: '32px' } }, 'font-size')}
      {colorStyle(`${topicHeader}::after`, attrs?.topics?.advanced?.iconColor)}
      {colorStyle(`${topicHeader}.is-active::after`, attrs?.topics?.advanced?.iconActiveColor)}
      {colorStyle(`${topicHeader}:hover::after`, attrs?.topics?.advanced?.iconHoverColor)}
      {colorStyle(topicHeader, attrs?.topics?.advanced?.textColor)}
      {colorStyle(`${topicHeader}.is-active`, attrs?.topics?.advanced?.textActiveColor)}
      {colorStyle(`${topicHeader}:hover`, attrs?.topics?.advanced?.textHoverColor)}
      {colorStyle(topicHeader, attrs?.topics?.advanced?.backgroundColor, 'background-color')}
      {colorStyle(`${topicHeader}.is-active`, attrs?.topics?.advanced?.backgroundActiveColor, 'background-color')}
      {colorStyle(`${topicHeader}:hover`, attrs?.topics?.advanced?.backgroundHoverColor, 'background-color')}
      {lengthStyle(topicItem, attrs?.topics?.advanced?.spaceBetween ?? { desktop: { value: '10px' } }, 'margin-bottom')}
      {lengthStyle(lessonIcon, attrs?.lesson?.advanced?.iconSize ?? { desktop: { value: '18px' } }, 'font-size')}
      {colorStyle(lessonIcon, attrs?.lesson?.advanced?.iconColor)}
      {colorStyle(lessonIconHover, attrs?.lesson?.advanced?.iconColorHover)}
      {colorStyle(lessonInfo, attrs?.lesson?.advanced?.infoColor)}
      {colorStyle(`${lessonInfo}:hover`, attrs?.lesson?.advanced?.infoColorHover)}
      {colorStyle(lessonItem, attrs?.lesson?.advanced?.backgroundColor, 'background-color')}
      {colorStyle(`${lessonItem}:hover`, attrs?.lesson?.advanced?.backgroundColorHover, 'background-color')}
      <CommonStyle
        selector={`${reviews} .tutor-review-summary .tutor-col-lg-auto`}
        attr={content.reviewsAlignment ?? { desktop: { value: 'center' } }}
        declarationFunction={({ attrValue }) => (attrValue ? `text-align: ${attrValue} !important;` : '')}
      />
      {colorStyle(`${ratingBars} .tutor-ratings .tutor-ratings-stars`, attrs?.ratingBar?.advanced?.starColor, 'color', true)}
      {lengthStyle(`${ratingBars} .tutor-ratings-progress-bar`, attrs?.ratingBar?.advanced?.height ?? { desktop: { value: '8px' } }, 'height', true)}
      {colorStyle(`${ratingBars} .tutor-progress-bar`, attrs?.ratingBar?.advanced?.barColor, 'background-color')}
      {colorStyle(`${ratingBars} .tutor-ratings-progress-bar .tutor-progress-value`, attrs?.ratingBar?.advanced?.fillColor, 'background-color')}
      {colorStyle(`${reviews} .tutor-review-summary`, attrs?.reviewSummary?.advanced?.background ?? { desktop: { value: 'rgb(255,255,255)' } }, 'background', true)}
      {colorStyle(`${reviews} .tutor-reviews .tutor-review-list-item`, attrs?.review?.advanced?.background ?? { desktop: { value: 'rgb(255,255,255)' } }, 'background', true)}
      {colorStyle(`${reviews} .tutor-reviews .tutor-review-list-item .tutor-ratings-stars`, attrs?.review?.advanced?.starColor, 'color', true)}
      {colorStyle(`${reviews} .tutor-reviews .tutor-review-list-item .tutor-ratings-stars:hover`, attrs?.review?.advanced?.starColorHover, 'color', true)}
    </StyleContainer>
  );
};

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

const CourseContentEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const benefitsLabel = desktopValue(content.benefitsLabel, 'What Will You Learn?');
  const topicsLabel = desktopValue(content.topicsLabel, 'Course Content');
  const reviewsLabel = desktopValue(content.reviewsLabel, 'Student Ratings & Reviews');
  const icon = desktopValue(content.icon, {});
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      benefits_label: String(benefitsLabel || ''),
      topics_label: String(topicsLabel || ''),
      reviews_label: String(reviewsLabel || ''),
      icon_unicode: icon?.unicode || '',
      icon_type: icon?.type || '',
      icon_weight: icon?.weight ? String(icon.weight) : '',
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-content?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [
    benefitsLabel,
    topicsLabel,
    reviewsLabel,
    icon?.unicode,
    icon?.type,
    icon?.weight,
  ]);

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
      <div className="et_pb_module_inner">
        {!isLoading && (
          <div dangerouslySetInnerHTML={{ __html: response?.html ?? '' }} />
        )}
      </div>
    </ModuleContainer>
  );
};

export const courseContentModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseContentEdit,
  },
};
