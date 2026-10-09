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

const tagLinkStyle = 'font-size: 16px; line-height: 26px; text-decoration: none; padding: 7px 23px; border: 1px solid #c0c3cb; color: #5b616f; border-radius: 6px; transition: 200ms;';

const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}) => {
  const wrapper = `${orderClass} .tutor-divi-course-tags-wrapper`;
  const title = `${wrapper} .tutor-segment-title`;
  const link = `${wrapper} .tutor-tag-list a`;

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
      {elements.style({ attrName: 'title' })}
      {elements.style({ attrName: 'tags' })}
      {elements.style({ attrName: 'list' })}
      <CommonStyle
        selector={link}
        attr={{ desktop: { value: 'tag' } }}
        declarationFunction={() => tagLinkStyle}
      />
      <CommonStyle
        selector={title}
        attr={attrs?.title?.advanced?.gap ?? { desktop: { value: '10px' } }}
        declarationFunction={({ attrValue }) => {
          const gap = cssLength(attrValue);

          return gap ? `margin-bottom: ${gap};` : '';
        }}
      />
      <CommonStyle
        selector={link}
        attr={attrs?.tags?.advanced?.background ?? {}}
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

const CourseTagsEdit = ({ attrs, id, name, elements }) => {
  const label = desktopValue(attrs?.content?.advanced?.label, 'Course Tags');
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
      restRoute: `/tutor-divi/v1/course-tags?${params.toString()}`,
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

export const courseTagsModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseTagsEdit,
  },
};
