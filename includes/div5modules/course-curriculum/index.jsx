import React, { useEffect } from 'react';
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

const withCourseOptions = (moduleMetadata) => {
  const data = typeof window !== 'undefined' ? (window.TutorLmsDivi5VisualBuilderData || {}) : {};
  const next = JSON.parse(JSON.stringify(moduleMetadata));
  const options = {};

  (data.courses || []).forEach((course) => {
    options[course.value] = { label: course.label };
  });

  next.attributes.content.settings.advanced.course.item.component.props.options = options;

  return next;
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

const colorStyle = (selector, attr, property = 'color') => (
  <CommonStyle
    selector={selector}
    attr={attr || {}}
    declarationFunction={({ attrValue }) => (
      attrValue ? `${property}: ${attrValue};` : ''
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
  const wrapper = `${orderClass} .dtlms-course-curriculum`;
  const header = `${wrapper} .tutor-accordion-item-header`;
  const icon = `${header}::after`;
  const topic = `${wrapper} .tutor-accordion-item`;
  const lessonIcon = `${orderClass} .tutor-accordion-item .tutor-course-content-list-item-icon, ${orderClass} .tutor-accordion-item .tutor-course-content-list-item-status`;
  const lessonIconHover = `${orderClass} .tutor-accordion-item .tutor-course-content-list-item-icon:hover, ${orderClass} .tutor-accordion-item .tutor-course-content-list-item-status:hover`;
  const lesson = `${orderClass} .tutor-accordion-item .tutor-course-content-list-item`;
  const lessonInfo = `${orderClass} .tutor-accordion-item .tutor-course-content-list-item-duration`;
  const topics = attrs?.topics?.advanced ?? {};
  const lessonAttr = attrs?.lesson?.advanced ?? {};

  return (
    <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
      {fixedStyle(header, 'display: flex; align-items: center; column-gap: 10px;')}
      {fixedStyle(topic, 'border: 1px solid #DCE4E6;')}
      {fixedStyle(`${orderClass} ul.tutor-courses-lession-list`, 'padding: 0 !important;')}
      {elements.style({
        attrName: 'module',
        styleProps: {
          disabledOn: {
            disabledModuleVisibility: settings?.disabledModuleVisibility,
          },
        },
      })}
      {elements.style({ attrName: 'header' })}
      {elements.style({ attrName: 'topics' })}
      {elements.style({ attrName: 'lesson' })}
      {lengthStyle(`${wrapper} .tutor-course-content-title`, attrs?.header?.advanced?.gap ?? { desktop: { value: '5px' } }, 'margin-top', true)}
      <CommonStyle
        selector={icon}
        attr={attrs?.content?.advanced?.iconPosition ?? { desktop: { value: 'right' } }}
        declarationFunction={({ attrValue }) => (
          attrValue === 'left' ? 'position: inherit !important; padding-left: 20px;' : ''
        )}
      />
      {lengthStyle(icon, topics.iconSize ?? { desktop: { value: '32px' } }, 'font-size')}
      {colorStyle(icon, topics.iconColor)}
      {colorStyle(`${header}.is-active::after`, topics.iconActiveColor)}
      {colorStyle(`${header}:hover::after`, topics.iconHoverColor)}
      {colorStyle(header, topics.textColor)}
      {colorStyle(`${header}.is-active`, topics.textActiveColor)}
      {colorStyle(`${header}.is-active:hover`, topics.textHoverColor)}
      {colorStyle(header, topics.backgroundColor, 'background-color')}
      {colorStyle(`${header}.is-active`, topics.backgroundActiveColor, 'background-color')}
      {colorStyle(`${header}:hover`, topics.backgroundHoverColor, 'background-color')}
      {lengthStyle(topic, topics.spaceBetween ?? { desktop: { value: '10px' } }, 'margin-bottom')}
      {lengthStyle(lessonIcon, lessonAttr.iconSize ?? { desktop: { value: '18px' } }, 'font-size')}
      {colorStyle(lessonIcon, lessonAttr.iconColor)}
      {colorStyle(lessonIconHover, lessonAttr.iconColorHover)}
      {colorStyle(lessonInfo, lessonAttr.infoColor)}
      {colorStyle(`${lessonInfo}:hover`, lessonAttr.infoColorHover)}
      {colorStyle(lesson, lessonAttr.backgroundColor, 'background-color')}
      {colorStyle(`${lesson}:hover`, lessonAttr.backgroundColorHover, 'background-color')}
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

const CourseCurriculumEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const courseId = desktopValue(content.course, '');
  const label = desktopValue(content.label, 'Course Content');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      course: String(courseId || ''),
      label: String(label || ''),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-curriculum?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [courseId, label]);

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

export const courseCurriculumModule = {
  metadata: withCourseOptions(metadata),
  conversionOutline,
  renderers: {
    edit: CourseCurriculumEdit,
  },
};
