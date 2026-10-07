import { addAction } from '@wordpress/hooks';
import { registerModule } from '@divi/module-library';
import { courseTitleModule } from './course-title/index.jsx';
import { courseAboutModule } from './course-about/index.jsx';
import { courseAuthorModule } from './course-author/index.jsx';
import { courseListModule } from './course-list/index.jsx';
import { courseCarouselModule } from './course-carousel/index.jsx';
import { courseBenefitsModule } from './course-benefits/index.jsx';

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
});
