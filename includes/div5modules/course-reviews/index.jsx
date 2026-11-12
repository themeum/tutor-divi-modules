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

const cssLength = (value) => {
  const length = `${value ?? ''}`.trim();

  if (!length) {
    return '';
  }

  return /^-?\d+(\.\d+)?$/.test(length) ? `${length}px` : length;
};

const desktopValue = (attr, fallback) => {
  const value = attr?.desktop?.value;

  if (value === undefined || value === null || value === '') {
    return fallback;
  }

  return value;
};

const editingPostId = () => {
  try {
    const postId = select('divi/settings')?.getSetting?.(['post', 'id']);

    return postId ? String(postId) : '';
  } catch (error) {
    return '';
  }
};

const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}) => {
  const ratingBar = attrs?.ratingBar?.advanced ?? {};
  const summary = `${orderClass} .tutor-review-summary-ratings`;

  return (
    <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
      {elements.style({
        attrName: 'module',
        styleProps: {
          disabledOn: {
            disabledModuleVisibility: settings?.disabledModuleVisibility,
          },
        },
      })}
      {elements.style({ attrName: 'sectionTitle' })}
      {elements.style({ attrName: 'avgTotal' })}
      {elements.style({ attrName: 'avgText' })}
      {elements.style({ attrName: 'avgStar' })}
      {elements.style({ attrName: 'ratingBar' })}
      {elements.style({ attrName: 'listAvatar' })}
      {elements.style({ attrName: 'authorName' })}
      {elements.style({ attrName: 'listTime' })}
      {elements.style({ attrName: 'listComment' })}
      {elements.style({ attrName: 'listStar' })}
      {elements.style({ attrName: 'section' })}
      <CommonStyle
        selector={`${summary} .tutor-ratings .tutor-ratings-stars`}
        attr={ratingBar.starColor ?? {}}
        declarationFunction={({ attrValue }) => (
          attrValue ? `color: ${attrValue};` : ''
        )}
      />
      <CommonStyle
        selector={`${summary} .tutor-ratings-progress-bar`}
        attr={ratingBar.barHeight ?? { desktop: { value: '8px' } }}
        declarationFunction={({ attrValue }) => {
          const height = cssLength(attrValue);

          return height ? `height: ${height} !important;` : '';
        }}
      />
      <CommonStyle
        selector={`${summary} .tutor-progress-bar`}
        attr={ratingBar.barColor ?? {}}
        declarationFunction={({ attrValue }) => (
          attrValue ? `background-color: ${attrValue};` : ''
        )}
      />
      <CommonStyle
        selector={`${summary} .tutor-ratings-progress-bar .tutor-progress-value`}
        attr={ratingBar.barFillColor ?? {}}
        declarationFunction={({ attrValue }) => (
          attrValue ? `background-color: ${attrValue};` : ''
        )}
      />
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

const CourseReviewsEdit = ({ attrs, id, name, elements }) => {
  const label = desktopValue(attrs?.content?.advanced?.label, 'Student Ratings & Reviews ');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      label: String(label || ''),
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-reviews?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [label]);

  const html = response?.html ?? '';

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
          <div dangerouslySetInnerHTML={{ __html: html }} />
        )}
      </div>
    </ModuleContainer>
  );
};

export const courseReviewsModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseReviewsEdit,
  },
};
