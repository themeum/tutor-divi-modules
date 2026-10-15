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

const editingPostId = () => {
  try {
    const postId = select('divi/settings')?.getSetting?.(['post', 'id']);

    return postId ? String(postId) : '';
  } catch (error) {
    return '';
  }
};

const colorStyle = (selector, attr, property) => (
  <CommonStyle
    selector={selector}
    attr={attr}
    declarationFunction={({ attrValue }) => {
      const color = `${attrValue ?? ''}`.trim();

      return color ? `${property}: ${color} !important;` : '';
    }}
  />
);

const styleNames = ['module', 'title', 'name', 'jobTitle', 'avatar', 'section'];

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
    {styleNames.map((name) => (
      <React.Fragment key={name}>
        {elements.style(name === 'module' ? {
          attrName: name,
          styleProps: {
            disabledOn: {
              disabledModuleVisibility: settings?.disabledModuleVisibility,
            },
          },
        } : {
          attrName: name,
        })}
      </React.Fragment>
    ))}
    {colorStyle(`${orderClass} .tutor-avatar-text`, attrs?.avatar?.advanced?.backgroundColor, 'background-color')}
    {colorStyle(`${orderClass} .tutor-avatar-text`, attrs?.avatar?.advanced?.textColor, 'color')}
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

const CourseInstructorEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const label = desktopValue(content.label, 'A Course by');
  const profilePicture = desktopValue(content.profilePicture, 'on');
  const displayName = desktopValue(content.displayName, 'on');
  const designation = desktopValue(content.designation, 'on');
  const link = desktopValue(content.link, '_blank');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      label: String(label || ''),
      profile_picture: String(profilePicture || 'on'),
      display_name: String(displayName || 'on'),
      designation: String(designation || 'on'),
      link: String(link || '_blank'),
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-instructor?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [
    label,
    profilePicture,
    displayName,
    designation,
    link,
  ]);

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

export const courseInstructorModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseInstructorEdit,
  },
};
