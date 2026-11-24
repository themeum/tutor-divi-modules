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

const flexAlignment = (alignment) => {
  if (alignment === 'center') {
    return 'center';
  }

  if (alignment === 'right') {
    return 'flex-end';
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
  const stars = attrs?.stars?.advanced ?? {};
  const layout = desktopValue(advanced.layout, 'row') === 'column' ? 'column' : 'row';
  const ratings = `${orderClass} .tutor-ratings`;
  const starGroup = `${orderClass} .dtlms-rating-wrapper .tutor-ratings-stars`;
  const starIcon = `${starGroup} span`;

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
      {elements.style({ attrName: 'countText' })}
      {elements.style({ attrName: 'avgText' })}
      <CommonStyle
        selector={ratings}
        attr={advanced.alignment ?? { desktop: { value: 'left' } }}
        declarationFunction={({ attrValue }) => {
          const alignment = flexAlignment(attrValue || 'left');
          const property = layout === 'column' ? 'align-items' : 'justify-content';

          return `display: flex; flex-direction: ${layout}; column-gap: 3px; ${property}: ${alignment};`;
        }}
      />
      <CommonStyle
        selector={ratings}
        attr={advanced.gap ?? {}}
        declarationFunction={({ attrValue }) => {
          const gap = cssLength(attrValue);

          if (!gap) {
            return '';
          }

          const property = layout === 'column' ? 'row-gap' : 'column-gap';

          return `${property}: ${gap};`;
        }}
      />
      <CommonStyle
        selector={starGroup}
        attr={{ desktop: { value: 'row' } }}
        declarationFunction={() => 'display: flex; flex-direction: row;'}
      />
      <CommonStyle
        selector={starIcon}
        attr={stars.color ?? { desktop: { value: '#ed9700' } }}
        declarationFunction={({ attrValue }) => (
          attrValue ? `color: ${attrValue};` : ''
        )}
      />
      <CommonStyle
        selector={starIcon}
        attr={stars.size ?? {}}
        declarationFunction={({ attrValue }) => {
          const size = cssLength(attrValue);

          return size ? `font-size: ${size};` : '';
        }}
      />
      <CommonStyle
        selector={starGroup}
        attr={stars.gap ?? {}}
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

const CourseRatingEdit = ({ attrs, id, name, elements }) => {
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-rating?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, []);

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

export const courseRatingModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseRatingEdit,
  },
};
