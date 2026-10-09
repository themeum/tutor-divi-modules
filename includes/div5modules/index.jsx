import { addAction } from '@wordpress/hooks';
import { registerModule } from '@divi/module-library';
import { courseTitleModule } from './course-title/index.jsx';
import { courseAboutModule } from './course-about/index.jsx';
import { courseAuthorModule } from './course-author/index.jsx';
import { courseListModule } from './course-list/index.jsx';
import { courseCarouselModule } from './course-carousel/index.jsx';
import { courseBenefitsModule } from './course-benefits/index.jsx';
import { courseCategoriesModule } from './course-categories/index.jsx';
import { courseContentModule } from './course-content/index.jsx';
import { courseCurriculumModule } from './course-curriculum/index.jsx';
import { courseDurationModule } from './course-duration/index.jsx';
import { courseEnrollmentModule } from './course-enrollment/index.jsx';
import { courseInstructorModule } from './course-instructor/index.jsx';
import { courseLastUpdateModule } from './course-last-update/index.jsx';
import { courseLevelModule } from './course-level/index.jsx';
import { courseMaterialsModule } from './course-materials/index.jsx';
import { coursePriceModule } from './course-price/index.jsx';
import { coursePurchaseModule } from './course-purchase/index.jsx';
import { courseRatingModule } from './course-rating/index.jsx';
import { courseRequirementsModule } from './course-requirements/index.jsx';
import { courseReviewsModule } from './course-reviews/index.jsx';
import { courseShareModule } from './course-share/index.jsx';
import { courseStatusModule } from './course-status/index.jsx';

addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'tutorLms.divi5Modules', () => {
  registerModule(courseTitleModule.metadata, {
    conversionOutline: courseTitleModule.conversionOutline,
    renderers: courseTitleModule.renderers,
  });

  registerModule(courseAboutModule.metadata, {
    conversionOutline: courseAboutModule.conversionOutline,
    renderers: courseAboutModule.renderers,
  });

  registerModule(courseAuthorModule.metadata, {
    conversionOutline: courseAuthorModule.conversionOutline,
    renderers: courseAuthorModule.renderers,
  });

  registerModule(courseListModule.metadata, {
    conversionOutline: courseListModule.conversionOutline,
    renderers: courseListModule.renderers,
  });

  registerModule(courseCarouselModule.metadata, {
    conversionOutline: courseCarouselModule.conversionOutline,
    renderers: courseCarouselModule.renderers,
  });

  registerModule(courseBenefitsModule.metadata, {
    conversionOutline: courseBenefitsModule.conversionOutline,
    renderers: courseBenefitsModule.renderers,
  });

  registerModule(courseCategoriesModule.metadata, {
    conversionOutline: courseCategoriesModule.conversionOutline,
    renderers: courseCategoriesModule.renderers,
  });

  registerModule(courseContentModule.metadata, {
    conversionOutline: courseContentModule.conversionOutline,
    renderers: courseContentModule.renderers,
  });

  registerModule(courseCurriculumModule.metadata, {
    conversionOutline: courseCurriculumModule.conversionOutline,
    renderers: courseCurriculumModule.renderers,
  });

  registerModule(courseDurationModule.metadata, {
    conversionOutline: courseDurationModule.conversionOutline,
    renderers: courseDurationModule.renderers,
  });

  registerModule(courseEnrollmentModule.metadata, {
    conversionOutline: courseEnrollmentModule.conversionOutline,
    renderers: courseEnrollmentModule.renderers,
  });

  registerModule(courseInstructorModule.metadata, {
    conversionOutline: courseInstructorModule.conversionOutline,
    renderers: courseInstructorModule.renderers,
  });

  registerModule(courseLastUpdateModule.metadata, {
    conversionOutline: courseLastUpdateModule.conversionOutline,
    renderers: courseLastUpdateModule.renderers,
  });

  registerModule(courseLevelModule.metadata, {
    conversionOutline: courseLevelModule.conversionOutline,
    renderers: courseLevelModule.renderers,
  });

  registerModule(courseMaterialsModule.metadata, {
    conversionOutline: courseMaterialsModule.conversionOutline,
    renderers: courseMaterialsModule.renderers,
  });

  registerModule(coursePriceModule.metadata, {
    conversionOutline: coursePriceModule.conversionOutline,
    renderers: coursePriceModule.renderers,
  });

  registerModule(coursePurchaseModule.metadata, {
    conversionOutline: coursePurchaseModule.conversionOutline,
    renderers: coursePurchaseModule.renderers,
  });

  registerModule(courseRatingModule.metadata, {
    conversionOutline: courseRatingModule.conversionOutline,
    renderers: courseRatingModule.renderers,
  });

  registerModule(courseRequirementsModule.metadata, {
    conversionOutline: courseRequirementsModule.conversionOutline,
    renderers: courseRequirementsModule.renderers,
  });

  registerModule(courseReviewsModule.metadata, {
    conversionOutline: courseReviewsModule.conversionOutline,
    renderers: courseReviewsModule.renderers,
  });

  registerModule(courseShareModule.metadata, {
    conversionOutline: courseShareModule.conversionOutline,
    renderers: courseShareModule.renderers,
  });

  registerModule(courseStatusModule.metadata, {
    conversionOutline: courseStatusModule.conversionOutline,
    renderers: courseStatusModule.renderers,
  });
});
