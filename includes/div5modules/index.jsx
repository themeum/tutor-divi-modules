import { addAction } from '@wordpress/hooks';
import { registerModule } from '@divi/module-library';
import { courseTitleModule } from './course-title/index.jsx';
import { courseAboutModule } from './course-about/index.jsx';

addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'tutorLms.divi5Modules', () => {
  registerModule(courseTitleModule.metadata, {
    conversionOutline: courseTitleModule.conversionOutline,
    renderers: courseTitleModule.renderers,
  });

  registerModule(courseAboutModule.metadata, {
    conversionOutline: courseAboutModule.conversionOutline,
    renderers: courseAboutModule.renderers,
  });
});
