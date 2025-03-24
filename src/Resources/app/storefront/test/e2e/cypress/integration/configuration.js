describe('configuration checks', () => {
  it('checks gtm-js loaded after cookie consent', () => {
    cy.visit('/');
    cy.get('body').should('be.visible');
    cy.get('.main-navigation-link.active').contains('Home');

    cy.getDataLayerByEventName('gtm.js');
    cy.get('@dataLayerObject').then((dataLayerObject) => {
      expect(dataLayerObject).to.equal(undefined);
    });

    cy.get('[id^=sfToolbarMainContent-]').should('be.visible').then(($el) => {
      if ($el) {
        cy.get('[id^=sfToolbarHideButton-]').click();
      }
    });

    cy.get('.js-cookie-accept-all-button > button').click();
    cy.wait(1000);

    cy.getDataLayerByEventName('gtm.js');
    cy.get('@dataLayerObject').then((dataLayerObject) => {
      expect(dataLayerObject).to.be.a('object');
    });
  });
});
