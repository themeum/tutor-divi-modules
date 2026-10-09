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

const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}) => {
  const wrapper = `${orderClass} .tutor-course-target-audience-wrap`;
  const list = `${orderClass} .tutor-course-target-audience-items`;
  const item = `${list} li`;
  const icon = `${item} .et-pb-icon`;
  const layoutAttr = attrs?.content?.advanced?.layout ?? { desktop: { value: 'list' } };

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
      {elements.style({
        attrName: 'title',
      })}
      {elements.style({
        attrName: 'audienceText',
      })}
      {elements.style({
        attrName: 'list',
      })}
      <CommonStyle
        selector={wrapper}
        attr={{ desktop: { value: 'column' } }}
        declarationFunction={() => 'display: flex; flex-direction: column;'}
      />
      <CommonStyle
        selector={list}
        attr={{ desktop: { value: '0' } }}
        declarationFunction={() => 'padding: 0;'}
      />
      <CommonStyle
        selector={item}
        attr={{ desktop: { value: 'none' } }}
        declarationFunction={() => 'padding: 0; list-style: none; border-style: solid;'}
      />
      <CommonStyle
        selector={wrapper}
        attr={attrs?.title?.advanced?.gap ?? { desktop: { value: '10px' } }}
        declarationFunction={({ attrValue }) => {
          const gap = cssLength(attrValue);

          return gap ? `row-gap: ${gap};` : '';
        }}
      />
      <CommonStyle
        selector={item}
        attr={layoutAttr}
        declarationFunction={({ attrValue }) => (
          attrValue ? `display: ${attrValue} !important;` : ''
        )}
      />
      <CommonStyle
        selector={`${wrapper} .tutor-segment-title, ${wrapper} .tutor-course-target-audience-content`}
        attr={attrs?.content?.advanced?.alignment ?? { desktop: { value: 'left' } }}
        declarationFunction={({ attrValue }) => (
          attrValue ? `text-align: ${attrValue} !important;` : ''
        )}
      />
      <CommonStyle
        selector={`${item}:not(:last-child)`}
        attr={attrs?.list?.advanced?.spaceBetween ?? { desktop: { value: '10px' } }}
        declarationFunction={({ attrValue, breakpoint }) => {
          const space = cssLength(attrValue);
          const layout = breakpointValue(layoutAttr, breakpoint, 'list');

          if (!space) {
            return '';
          }

          const property = layout === 'list' ? 'margin-bottom' : 'margin-right';

          return `${property}: ${space} !important;`;
        }}
      />
      <CommonStyle
        selector={`${item} .list-item`}
        attr={attrs?.audienceText?.advanced?.indent ?? { desktop: { value: '7px' } }}
        declarationFunction={({ attrValue }) => {
          const indent = cssLength(attrValue);

          return indent ? `padding-left: ${indent} !important;` : '';
        }}
      />
      <CommonStyle
        selector={icon}
        attr={attrs?.icon?.advanced?.color ?? {}}
        declarationFunction={({ attrValue }) => (
          attrValue ? `color: ${attrValue} !important;` : ''
        )}
      />
      <CommonStyle
        selector={icon}
        attr={attrs?.icon?.advanced?.size ?? { desktop: { value: '12px' } }}
        declarationFunction={({ attrValue }) => {
          const size = cssLength(attrValue);

          return size ? `font-size: ${size} !important;` : '';
        }}
      />
      <CommonStyle
        selector={icon}
        attr={attrs?.content?.advanced?.icon ?? {}}
        declarationFunction={({ attrValue }) => {
          if (!attrValue || typeof attrValue !== 'object' || !attrValue.unicode) {
            return '';
          }

          const family = attrValue.type === 'fa' ? 'FontAwesome' : 'ETmodules';
          const weight = attrValue.weight ? ` font-weight: ${attrValue.weight};` : '';

          return `font-family: '${family}' !important;${weight}`;
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

const CourseTargetAudienceEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const label = desktopValue(content.label, 'Target Audience');
  const icon = desktopValue(content.icon, {});
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      label: String(label || ''),
      icon_unicode: icon?.unicode || '',
      icon_type: icon?.type || '',
      icon_weight: icon?.weight ? String(icon.weight) : '',
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-target-audience?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [
    label,
    icon?.unicode,
    icon?.type,
    icon?.weight,
  ]);

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

export const courseTargetAudienceModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseTargetAudienceEdit,
  },
};
