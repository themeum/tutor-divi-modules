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

const layoutValue = (layout) => (layout === 'column' ? 'column' : 'row');

const flexAlignment = (alignment) => {
  if (alignment === 'center') {
    return 'center';
  }

  if (alignment === 'right') {
    return 'flex-end';
  }

  return 'flex-start';
};

const styleDriver = (layoutAttr, alignmentAttr, gapAttr) => {
  const driver = {};

  ['desktop', 'tablet', 'phone'].forEach((device) => {
    driver[device] = {
      value: [
        layoutValue(breakpointValue(layoutAttr, device, 'row')),
        breakpointValue(alignmentAttr, device, 'left'),
        cssLength(breakpointValue(gapAttr, device, '10px')),
      ].join('|'),
    };
  });

  return driver;
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
  const driver = styleDriver(advanced.layout, advanced.alignment, advanced.gap);

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
      {elements.style({ attrName: 'valueText' })}
      <CommonStyle
        selector={`${orderClass} .tutor-divi-course-duration`}
        attr={driver}
        declarationFunction={({ breakpoint }) => {
          const layout = layoutValue(breakpointValue(advanced.layout, breakpoint, 'row'));
          const alignment = flexAlignment(breakpointValue(advanced.alignment, breakpoint, 'left'));
          const property = layout === 'column' ? 'align-items' : 'justify-content';

          return `display: flex; flex-direction: ${layout}; ${property}: ${alignment};`;
        }}
      />
      <CommonStyle
        selector={`${orderClass} .tutor-divi-course-duration`}
        attr={driver}
        declarationFunction={({ breakpoint }) => {
          const layout = layoutValue(breakpointValue(advanced.layout, breakpoint, 'row'));
          const gap = cssLength(breakpointValue(advanced.gap, breakpoint, '10px'));

          if (!gap) {
            return '';
          }

          const property = layout === 'column' ? 'row-gap' : 'column-gap';

          return `${property}: ${gap};`;
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

const CourseDurationEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const label = desktopValue(content.label, 'Course Duration');
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
      restRoute: `/tutor-divi/v1/course-duration?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [label]);

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

export const courseDurationModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseDurationEdit,
  },
};
