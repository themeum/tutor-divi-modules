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

const flexAlignment = (alignment) => {
  if (alignment === 'right') {
    return 'flex-end';
  }

  if (alignment === 'center') {
    return 'center';
  }

  return 'flex-start';
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
  const advanced = attrs?.content?.advanced ?? {};
  const link = `${orderClass} .dtlms-course-wishlist-wrapper a`;

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
      {elements.style({ attrName: 'labelText' })}
      {elements.style({ attrName: 'iconText' })}
      <CommonStyle
        selector={link}
        attr={advanced.alignment ?? { desktop: { value: 'left' } }}
        declarationFunction={({ attrValue }) => {
          const alignment = flexAlignment(attrValue || 'left');

          return `display: flex; align-items: center; justify-content: ${alignment};`;
        }}
      />
      <CommonStyle
        selector={link}
        attr={advanced.spaceBetween ?? { desktop: { value: '2px' } }}
        declarationFunction={({ attrValue }) => {
          const gap = cssLength(attrValue);

          return gap ? `column-gap: ${gap};` : '';
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

const CourseWishlistEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const label = desktopValue(content.label, 'Wishlist');
  const showLabel = desktopValue(content.showLabel, 'on');
  const showIcon = desktopValue(content.showIcon, 'on');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      label: String(label || ''),
      show_label: String(showLabel || 'on'),
      show_icon: String(showIcon || 'on'),
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-wishlist?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [label, showLabel, showIcon]);

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

export const courseWishlistModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseWishlistEdit,
  },
};
