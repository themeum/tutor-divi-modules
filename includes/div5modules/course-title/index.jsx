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
      attrName: 'title',
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

const CourseTitleEdit = ({ attrs, id, name, elements }) => {
  const courseId = attrs?.content?.advanced?.course?.desktop?.value ?? '';
  const headingLevel = attrs?.title?.decoration?.font?.font?.desktop?.value?.headingLevel ?? 'h1';
  const Header = headingLevel;
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
      restRoute: `/tutor-divi/v1/course-title?course=${encodeURIComponent(courseId)}`,
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

  const title = response?.title ?? '';

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
          <Header
            className="dtlms-course-title tutor-course-details-title tutor-fs-4 tutor-fw-bold tutor-color-black tutor-mt-12 tutor-mb-0"
            dangerouslySetInnerHTML={{ __html: title }}
          />
        )}
      </div>
    </ModuleContainer>
  );
};

export const courseTitleModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseTitleEdit,
  },
};
