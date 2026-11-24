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

const desktopValue = (attr, fallback) => attr?.desktop?.value || fallback;

const editingPostId = () => {
  try {
    const postId = select('divi/settings')?.getSetting?.(['post', 'id']);

    return postId ? String(postId) : '';
  } catch (error) {
    return '';
  }
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

const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}) => {
  const wrapper = `${orderClass} .tutor-single-course-author-meta`;
  const avatar = `${orderClass} .tutor-avatar, ${orderClass} .tutor-avatar img`;
  const layout = desktopValue(attrs?.content?.advanced?.layout, 'row');
  const alignment = flexAlignment(desktopValue(attrs?.content?.advanced?.alignment, 'left'));

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
        attrName: 'authorLabel',
      })}
      {elements.style({
        attrName: 'authorName',
      })}
      {elements.style({
        attrName: 'avatar',
      })}
      <CommonStyle
        selector={`${orderClass} .tutor-single-course-meta li.tutor-single-course-author-meta`}
        attr={{ desktop: { value: 'none' } }}
        declarationFunction={() => 'list-style: none;'}
      />
      <CommonStyle
        selector={`${orderClass} ul`}
        attr={{ desktop: { value: '0' } }}
        declarationFunction={() => 'padding: 0 !important;'}
      />
      <CommonStyle
        selector={`${wrapper} a`}
        attr={{ desktop: { value: '0' } }}
        declarationFunction={() => 'padding: 0;'}
      />
      <CommonStyle
        selector={wrapper}
        attr={attrs?.content?.advanced?.layout ?? { desktop: { value: 'row' } }}
        declarationFunction={({ attrValue }) => {
          const direction = attrValue === 'column' ? 'column' : 'row';
          const property = direction === 'column' ? 'align-items' : 'justify-content';

          return `display: flex !important; flex-direction: ${direction} !important; ${property}: ${alignment} !important;`;
        }}
      />
      <CommonStyle
        selector={avatar}
        attr={attrs?.avatar?.advanced?.size ?? { desktop: { value: '25px' } }}
        declarationFunction={({ attrValue }) => (
          attrValue ? `width: ${attrValue} !important; height: ${attrValue} !important;` : ''
        )}
      />
      <CommonStyle
        selector={`${orderClass} .tutor-single-course-avatar .tutor-text-avatar`}
        attr={attrs?.avatar?.advanced?.size ?? { desktop: { value: '25px' } }}
        declarationFunction={({ attrValue }) => (
          attrValue ? `line-height: ${attrValue}; text-align: center;` : ''
        )}
      />
      <CommonStyle
        selector={wrapper}
        attr={attrs?.avatar?.advanced?.gap ?? { desktop: { value: '5px' } }}
        declarationFunction={({ attrValue }) => {
          if (!attrValue) {
            return '';
          }

          const property = layout === 'column' ? 'row-gap' : 'column-gap';

          return `${property}: ${attrValue};`;
        }}
      />
      <CommonStyle
        selector={avatar}
        attr={attrs?.avatar?.advanced?.borderRadius ?? { desktop: { value: '100px' } }}
        declarationFunction={({ attrValue }) => (
          attrValue ? `border-radius: ${attrValue};` : ''
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

const CourseAuthorEdit = ({ attrs, id, name, elements }) => {
  const courseId = desktopValue(attrs?.content?.advanced?.course, '');
  const profilePicture = desktopValue(attrs?.content?.advanced?.profilePicture, 'on');
  const displayName = desktopValue(attrs?.content?.advanced?.displayName, 'on');
  const link = desktopValue(attrs?.content?.advanced?.link, 'new');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      course: courseId,
      et_post_id: editingPostId(),
      profile_picture: profilePicture,
      display_name: displayName,
      link,
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-author?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [courseId, profilePicture, displayName, link]);

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

export const courseAuthorModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseAuthorEdit,
  },
};
