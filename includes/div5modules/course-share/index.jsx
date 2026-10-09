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
  const social = attrs?.social?.advanced ?? {};
  const close = attrs?.close?.advanced ?? {};
  const link = `${orderClass} .dtlms-course-share a`;

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
      {elements.style({ attrName: 'shareLabel' })}
      {elements.style({ attrName: 'shareIcon' })}
      {elements.style({ attrName: 'popupTitle' })}
      {elements.style({ attrName: 'popupShareTitle' })}
      {elements.style({ attrName: 'shareInput' })}
      {elements.style({ attrName: 'shareLinkTitle' })}
      {elements.style({ attrName: 'socialIcon' })}
      {elements.style({ attrName: 'socialText' })}
      {elements.style({ attrName: 'social' })}
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
      <CommonStyle
        selector={`${orderClass} .tutor-social-share-button`}
        attr={social.background ?? {}}
        declarationFunction={({ attrValue }) => (
          attrValue ? `background-color: ${attrValue};` : ''
        )}
      />
      <CommonStyle
        selector={`${orderClass} .tutor-iconic-btn`}
        attr={close.color ?? {}}
        declarationFunction={({ attrValue }) => (
          attrValue ? `color: ${attrValue} !important;` : ''
        )}
      />
      <CommonStyle
        selector={`${orderClass} .tutor-iconic-btn`}
        attr={close.size ?? { desktop: { value: '30px' } }}
        declarationFunction={({ attrValue }) => {
          const size = cssLength(attrValue);

          return size ? `font-size: ${size} !important;` : '';
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

const CourseShareEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const popup = attrs?.popup?.advanced ?? {};
  const showLabel = desktopValue(content.showLabel, 'on');
  const showIcon = desktopValue(content.showIcon, 'on');
  const sectionTitle = desktopValue(popup.sectionTitle, 'Share Course');
  const shareTitle = desktopValue(popup.shareTitle, 'Share Course');
  const showSocialIcon = desktopValue(popup.showSocialIcon, 'on');
  const showSocialText = desktopValue(popup.showSocialText, 'on');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      show_label: String(showLabel || 'on'),
      show_icon: String(showIcon || 'on'),
      section_title: String(sectionTitle || ''),
      share_title: String(shareTitle || ''),
      show_social_icon: String(showSocialIcon || 'on'),
      show_social_text: String(showSocialText || 'on'),
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-share?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [
    showLabel,
    showIcon,
    sectionTitle,
    shareTitle,
    showSocialIcon,
    showSocialText,
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

export const courseShareModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseShareEdit,
  },
};
