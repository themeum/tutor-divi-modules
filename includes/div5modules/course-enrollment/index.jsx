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

const editingPostId = () => {
  try {
    const postId = select('divi/settings')?.getSetting?.(['post', 'id']);

    return postId ? String(postId) : '';
  } catch (error) {
    return '';
  }
};

const fixedStyle = (selector, declaration) => (
  <CommonStyle
    selector={selector}
    attr={{ desktop: { value: '1' } }}
    declarationFunction={() => declaration}
  />
);

const lengthStyle = (selector, attr, property) => (
  <CommonStyle
    selector={selector}
    attr={attr}
    declarationFunction={({ attrValue }) => {
      const length = cssLength(attrValue);

      return length ? `${property}: ${length} !important;` : '';
    }}
  />
);

const colorStyle = (selector, attr, property = 'color') => (
  <CommonStyle
    selector={selector}
    attr={attr}
    declarationFunction={({ attrValue }) => {
      const color = `${attrValue ?? ''}`.trim();

      return color ? `${property}: ${color} !important;` : '';
    }}
  />
);

const styleNames = [
  'module',
  'pricing',
  'planFeatureIcon',
  'planFeature',
  'subscriptionTitle',
  'subscriptionPrice',
  'subscriptionPeriod',
  'progressTitle',
  'progressBar',
  'expireIcon',
  'expireValue',
  'expireLabel',
  'expire',
  'enrolledDate',
  'monetization',
  'metaLabel',
  'metaValue',
  'meta',
  'enrolledText',
  'enrolledInfo',
  'enrollButton',
  'buyNowButton',
  'addToCartButton',
  'startButton',
  'completeButton',
  'card',
  'cardBody',
  'cardInfo',
  'courseAlert',
  'subscriptionPlan',
  'planFeatureList',
];

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
    {fixedStyle(`${orderClass} .tutor-card-body.tutor-p-30`, 'display: flex; flex-direction: column; row-gap: 10px;')}
    {fixedStyle(`${orderClass} .enrolment-expire-info .tutor-ml-4`, 'margin-left: 4px !important;')}
    {fixedStyle(`${orderClass} .tutor-form-check-input`, 'appearance: none !important;')}
    {fixedStyle(`${orderClass} .tutor-btn.tutor-d-none`, 'display: none !important;')}
    {fixedStyle(`${orderClass} .tutor-btn`, 'display: inline-flex !important;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-width-auto form`, 'display: inline-flex !important;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-width-auto .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)`, 'display: flex; flex-direction: column;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-align-left .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper), ${orderClass} .dtlms-enroll-btn-align-left form`, 'align-items: flex-start;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-align-center .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper), ${orderClass} .dtlms-enroll-btn-align-center form`, 'align-items: center;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-align-right .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper), ${orderClass} .dtlms-enroll-btn-align-right form`, 'align-items: flex-end;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-width-fill .tutor-course-sidebar-card-btns, ${orderClass} .dtlms-enroll-btn-width-fill .tutor-course-sidebar-card-body form`, 'width: 100%;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-width-auto .tutor-btn`, 'width: auto !important; display: inline-flex !important;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-size-large .tutor-btn`, 'font-size: 18px; padding: 10px 20px;')}
    {fixedStyle(`${orderClass} .dtlms-enroll-btn-size-small .tutor-btn`, 'font-size: 14px; padding: 5px 12px;')}
    {fixedStyle(`${orderClass} .tutor-card-body a`, 'line-height: inherit; padding-bottom: 8px !important;')}
    {fixedStyle(`${orderClass} .tutor-plan-feature-item`, 'display: flex; align-items: center;')}
    {fixedStyle(`${orderClass} .tutor-subscription-plan-wrapper`, 'display: flex; flex-direction: column;')}
    {fixedStyle(`${orderClass} .tutor-course-subscription-plan`, 'display: block;')}
    {fixedStyle(`${orderClass} .tutor-plan-feature-list`, 'display: flex; flex-direction: column;')}
    {fixedStyle(`${orderClass} .tutor-alert .tutor-alert-text`, 'display: flex;')}
    {fixedStyle(`${orderClass} .tutor-sidebar-card .tutor-card-body`, 'display: flex; flex-direction: column; row-gap: 10px;')}
    {lengthStyle(`${orderClass} .dtlms-enroll-btn-width-fixed button, ${orderClass} .dtlms-enroll-btn-width-fixed .tutor-button, ${orderClass} .dtlms-enroll-btn-width-fixed .start-continue-retake-button`, attrs?.content?.advanced?.widthPx, 'width')}
    <CommonStyle
      selector={`${orderClass} .dtlms-enroll-btn-width-auto .tutor-card-body`}
      attr={attrs?.content?.advanced?.alignment}
      declarationFunction={({ attrValue }) => {
        const alignment = ['left', 'center', 'right'].includes(attrValue) ? attrValue : 'center';

        return `text-align: ${alignment} !important;`;
      }}
    />
    {lengthStyle(`${orderClass} .tutor-card`, attrs?.card?.advanced?.gap, 'row-gap')}
    {lengthStyle(`${orderClass} .tutor-card-footer .dtlms-enrollment-meta-label`, attrs?.meta?.advanced?.iconSize, 'font-size')}
    {colorStyle(`${orderClass} .tutor-card-footer .dtlms-enrollment-meta-label`, attrs?.meta?.advanced?.iconColor)}
    {lengthStyle(`${orderClass} .tutor-icon-purchase-mark`, attrs?.enrolledIcon?.advanced?.size, 'font-size')}
    {colorStyle(`${orderClass} .tutor-icon-purchase-mark`, attrs?.enrolledIcon?.advanced?.color)}
    {colorStyle(`${orderClass} .tutor-card .tutor-card-body`, attrs?.cardBody?.advanced?.backgroundColor, 'background-color')}
    {colorStyle(`${orderClass} .tutor-course-progress-wrapper .tutor-progress-bar`, attrs?.progress?.advanced?.barBackground, 'background-color')}
    {lengthStyle(`${orderClass} .dtlms-course-enroll-info-wrapper`, attrs?.enrolledInfo?.advanced?.gap, 'column-gap')}
    {colorStyle(`${orderClass} .tutor-alert`, attrs?.courseAlert?.advanced?.backgroundColor, 'background-color')}
    {lengthStyle(`${orderClass} .tutor-alert .tutor-alert-text`, attrs?.courseAlert?.advanced?.gap, 'column-gap')}
    {colorStyle(`${orderClass} .tutor-alert-icon`, attrs?.courseAlert?.advanced?.iconColor)}
    {lengthStyle(`${orderClass} .tutor-subscription-plan-wrapper`, attrs?.subscription?.advanced?.gap, 'gap')}
    {colorStyle(`${orderClass} .tutor-course-subscription-plan`, attrs?.subscriptionPlan?.advanced?.backgroundColor, 'background-color')}
    {lengthStyle(`${orderClass} .tutor-plan-feature-list`, attrs?.planFeatureList?.advanced?.gap, 'gap')}
    {lengthStyle(`${orderClass} .tutor-plan-feature-item`, attrs?.planFeature?.advanced?.gap, 'gap')}
    {colorStyle(`${orderClass} .tutor-plan-feature-item i`, attrs?.planFeatureIcon?.advanced?.color)}
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

const CourseEnrollmentEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const previewMode = desktopValue(content.previewMode, 'enrollment');
  const enrollmentBox = desktopValue(content.enrollmentBox, 'on');
  const buttonSize = desktopValue(content.buttonSize, 'medium');
  const alignment = desktopValue(content.alignment, 'center');
  const btnWidth = desktopValue(content.btnWidth, 'fill');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      preview_mode: String(previewMode || 'enrollment'),
      enrollment_box: String(enrollmentBox || 'on'),
      button_size: String(buttonSize || 'medium'),
      alignment: String(alignment || 'center'),
      btn_width: String(btnWidth || 'fill'),
      et_post_id: editingPostId(),
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-enrollment?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [
    previewMode,
    enrollmentBox,
    buttonSize,
    alignment,
    btnWidth,
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

export const courseEnrollmentModule = {
  metadata,
  conversionOutline,
  renderers: {
    edit: CourseEnrollmentEdit,
  },
};
