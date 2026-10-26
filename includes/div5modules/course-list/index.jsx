import React, { useEffect } from 'react';
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

  if (Array.isArray(value)) {
    return value;
  }

  if (value === undefined || value === null || value === '') {
    return fallback;
  }

  return value;
};

const includesParam = (value) => {
  if (Array.isArray(value)) {
    return value.join(',');
  }

  if (value && typeof value === 'object') {
    return Object.keys(value)
      .filter((key) => value[key] === 'on' || value[key] === true)
      .join(',');
  }

  return value || '';
};

const hiddenWhenOff = ({ attrValue }) => (
  attrValue === 'off' ? 'display: none !important;' : ''
);

const withCheckboxOptions = (moduleMetadata) => {
  const data = typeof window !== 'undefined' ? (window.TutorLmsDivi5VisualBuilderData || {}) : {};
  const next = JSON.parse(JSON.stringify(moduleMetadata));
  const advanced = next.attributes.content.settings.advanced;

  advanced.categoryIncludes.item.component.props.options = data.categories || [];
  advanced.authorIncludes.item.component.props.options = data.authors || [];

  return next;
};

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
    {elements.style({
      attrName: 'meta',
    })}
    {elements.style({
      attrName: 'category',
    })}
    <CommonStyle
      selector={`${orderClass} .tutor-course-thumbnail`}
      attr={attrs?.content?.advanced?.showImage ?? { desktop: { value: 'on' } }}
      declarationFunction={hiddenWhenOff}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-course-ratings, ${orderClass} .tutor-ratings`}
      attr={attrs?.content?.advanced?.rating ?? { desktop: { value: 'on' } }}
      declarationFunction={hiddenWhenOff}
    />
    <CommonStyle
      selector={`${orderClass} .dtlms-course-duration-meta`}
      attr={attrs?.content?.advanced?.metaData ?? { desktop: { value: 'off' } }}
      declarationFunction={hiddenWhenOff}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-grid`}
      attr={attrs?.layout?.advanced?.columnsGap ?? {}}
      declarationFunction={({ attrValue }) => (
        attrValue ? `grid-column-gap: ${attrValue} !important;` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-grid`}
      attr={attrs?.layout?.advanced?.rowsGap ?? {}}
      declarationFunction={({ attrValue }) => (
        attrValue ? `grid-row-gap: ${attrValue} !important;` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-course-card, ${orderClass} .dtlms-course-list-col .dtlms-course-card-inner`}
      attr={attrs?.card?.advanced?.backgroundColor ?? {}}
      declarationFunction={({ attrValue }) => (
        attrValue ? `background-color: ${attrValue};` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-ratings-stars span`}
      attr={attrs?.rating?.advanced?.starColor ?? {}}
      declarationFunction={({ attrValue }) => (
        attrValue ? `color: ${attrValue};` : ''
      )}
    />
    <CommonStyle
      selector={`${orderClass} .tutor-ratings-stars span`}
      attr={attrs?.rating?.advanced?.starSize ?? { desktop: { value: '18px' } }}
      declarationFunction={({ attrValue }) => (
        attrValue ? `font-size: ${attrValue};` : ''
      )}
    />
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

const CourseListEdit = ({ attrs, id, name, elements }) => {
  const content = attrs?.content?.advanced ?? {};
  const skin = desktopValue(content.skin, 'classic');
  const columns = desktopValue(content.columns, '3');
  const hoverAnimation = desktopValue(content.hoverAnimation, 'on');
  const imageSize = desktopValue(content.imageSize, 'medium_large');
  const avatar = desktopValue(content.avatar, 'on');
  const author = desktopValue(content.author, 'on');
  const difficultyLabel = desktopValue(content.difficultyLabel, 'off');
  const wishList = desktopValue(content.wishList, 'on');
  const showCategory = desktopValue(content.showCategory, 'off');
  const footer = desktopValue(content.footer, 'on');
  const pagination = desktopValue(content.pagination, 'on');
  const orderBy = desktopValue(content.orderBy, 'date');
  const order = desktopValue(content.order, 'DESC');
  const limit = desktopValue(content.limit, '6');
  const categoryIncludes = includesParam(desktopValue(content.categoryIncludes, []));
  const authorIncludes = includesParam(desktopValue(content.authorIncludes, []));
  const paginationType = desktopValue(content.paginationType, 'prev_next');
  const prevLabel = desktopValue(content.prevLabel, 'Previous');
  const nextLabel = desktopValue(content.nextLabel, 'Next');
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({});

  useEffect(() => {
    const params = new URLSearchParams({
      skin,
      columns: String(columns),
      hover_animation: hoverAnimation,
      image_size: imageSize,
      avatar,
      author,
      difficulty_label: difficultyLabel,
      wish_list: wishList,
      show_category: showCategory,
      footer,
      pagination,
      order_by: orderBy,
      order,
      limit: String(limit),
      category_includes: categoryIncludes,
      author_includes: authorIncludes,
      pagination_type: paginationType,
      prev_level: prevLabel,
      next_level: nextLabel,
    });

    fetch({
      restRoute: `/tutor-divi/v1/course-list?${params.toString()}`,
      method: 'GET',
    }).catch((error) => {
      console.error(error);
    });
  }, [
    skin,
    columns,
    hoverAnimation,
    imageSize,
    avatar,
    author,
    difficultyLabel,
    wishList,
    showCategory,
    footer,
    pagination,
    orderBy,
    order,
    limit,
    categoryIncludes,
    authorIncludes,
    paginationType,
    prevLabel,
    nextLabel,
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

export const courseListModule = {
  metadata: withCheckboxOptions(metadata),
  conversionOutline,
  renderers: {
    edit: CourseListEdit,
  },
};
