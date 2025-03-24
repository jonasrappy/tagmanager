const {defineConfig} = require('cypress');
const setupNodeEvents = require('./cypress/plugins');

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://local.shopware',
    specPattern: 'cypress/integration/**/*.{js,ts}',
    supportFile: 'cypress/support/index.js',
    screenshotsFolder: 'cypress/screenshots',
    video: true,
    videosFolder: 'cypress/videos',
    viewportWidth: 1280,
    viewportHeight: 720,
    setupNodeEvents: setupNodeEvents,
  },
});
