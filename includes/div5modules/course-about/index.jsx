import React, { useEffect, useRef } from 'react';
import { useFetch } from '@divi/rest';
import {
  ModuleContainer,
  StyleContainer,
  elementClassnames,
} from '@divi/module';
import metadata from './module.json';
import conversionOutline from './conversion-outline.json';

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
      attrName: 'heading',
    })}
    {elements.style({
      attrName: 'aboutText',
    })}
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

const CourseAboutEdit = ({ attrs, id, name, elements }) => {
  const courseId = attrs?.content?.advanced?.course?.desktop?.value ?? '';
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});
  const fetchAbortRef = useRef();

  useEffect(() => {
    if (fetchAbortRef.current) {
      fetchAbortRef.current.abort();
    }

    fetchAbortRef.current = new AbortController();

    fetch({
      restRoute: `/tutor-divi/v1/course-about?course=${encodeURIComponent(courseId)}`,
      method: 'GET',
      signal: fetchAbortRef.current.signal,
    }).catch((error) => {
      console.error(error);
    });

    return () => {
      if (fetchAbortRef.current) {
        fetchAbortRef.current.abort();
      }
    };
  }, [courseId]);

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

export const courseAboutModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseAboutEdit,
  },
};
