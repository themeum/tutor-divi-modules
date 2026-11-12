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
  const progress = attrs?.progress?.advanced ?? {};
  const bar = `${orderClass} .tutor-progress-bar`;

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
      {elements.style({ attrName: 'statusTitle' })}
      {elements.style({ attrName: 'statusText' })}
      <CommonStyle
        selector={bar}
        attr={progress.barHeight ?? { desktop: { value: '7px' } }}
        declarationFunction={({ attrValue }) => {
          const height = cssLength(attrValue);

          return height ? `height: ${height};` : '';
        }}
      />
      <CommonStyle
        selector={bar}
        attr={progress.barRadius ?? { desktop: { value: '30px' } }}
        declarationFunction={({ attrValue }) => {
          const radius = cssLength(attrValue);

          return radius ? `border-radius: ${radius} !important;` : '';
        }}
      />
      <CommonStyle
        selector={bar}
        attr={progress.barBackground ?? {}}
        declarationFunction={({ attrValue }) => (
          attrValue ? `background-color: ${attrValue};` : ''
        )}
      />
      <CommonStyle
        selector={`${orderClass} .tutor-progress-value`}
        attr={progress.barColor ?? {}}
        declarationFunction={({ attrValue }) => (
          attrValue ? `background-color: ${attrValue};` : ''
        )}
      />
      <CommonStyle
        selector={bar}
        attr={progress.barGap ?? { desktop: { value: '10px' } }}
        declarationFunction={({ attrValue }) => {
          const gap = cssLength(attrValue);

          return gap ? `margin-top: ${gap};` : '';
        }}
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

const CourseStatusEdit = ({ attrs, id, name, elements }) => {
  const title = desktopValue(attrs?.content?.advanced?.progressTitle, 'Course Progress');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      title: String(title || ''),
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-status?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [title]);

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

export const courseStatusModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseStatusEdit,
  },
};
