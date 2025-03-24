Cypress.Commands.add('getDataLayerByEventName', (eventName) => {
  return cy.window().then((window) => {
    expect(window.dataLayer).to.be.a('array');
    const dataLayerObject = window.dataLayer.find((object) => {
      return object.event === eventName;
    });

    cy.wrap(dataLayerObject).as('dataLayerObject');
  });
});
Cypress.Commands.add('getLastDataLayer', () => {
  return cy.window().then((window) => {
    expect(window.dataLayer).to.be.a('array');
    const dataLayerObject = window.dataLayer[window.dataLayer.length - 1];

    cy.wrap(dataLayerObject).as('dataLayerObject');
  });
});
