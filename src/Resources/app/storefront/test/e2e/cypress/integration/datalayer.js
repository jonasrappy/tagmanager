import {checkDataLayerItems} from '../support/checks';

describe('module: "Home Page"', () => {
  it('checks the datalayer content', () => {
    cy.visit('/');
    cy.get('body').should('be.visible');

    cy.fixture('home-page').then(expectedDataLayer => {
      cy.getDataLayerByEventName('view_item_list');
      cy.get('@dataLayerObject').then((dataLayerObject) => {
        expect(dataLayerObject).to.be.a('object');
        expect(dataLayerObject.event).to.equal(expectedDataLayer.event);
        expect(dataLayerObject.ecommerce.item_list_name).to.equal(expectedDataLayer.ecommerce.item_list_name);
        expect(dataLayerObject.ecommerce.item_list_id).to.equal(expectedDataLayer.ecommerce.item_list_id);
        checkDataLayerItems(dataLayerObject, expectedDataLayer);
      });
    });
  });
});

describe('module: "Listing (ajax)"', () => {
  it('checks the datalayer content', () => {
    cy.visit('/');
    cy.get('body').should('be.visible');

    cy.get('.filter-panel-item-toggle.btn').first().click();
    cy.get('.form-check-input').first().click();
    cy.wait(300);

    cy.fixture('listing-ajax').then(expectedDataLayer => {
      cy.getLastDataLayer();
      cy.get('@dataLayerObject').then((dataLayerObject) => {
        expect(dataLayerObject).to.be.a('object');
        expect(dataLayerObject.event).to.equal(expectedDataLayer.event);
        expect(dataLayerObject.ecommerce.item_list_name).to.equal(expectedDataLayer.ecommerce.item_list_name);
        expect(dataLayerObject.ecommerce.item_list_id).to.equal(expectedDataLayer.ecommerce.item_list_id);
        checkDataLayerItems(dataLayerObject, expectedDataLayer);
      });
    });
  });
});

describe('module: "Category Page"', () => {
  it('checks the datalayer content', () => {
    cy.visit('/clothing/');
    cy.get('body').should('be.visible');

    cy.fixture('category-page').then(expectedDataLayer => {
      cy.getDataLayerByEventName('view_item_list');
      cy.get('@dataLayerObject').then((dataLayerObject) => {
        expect(dataLayerObject).to.be.a('object');
        expect(dataLayerObject.event).to.equal(expectedDataLayer.event);
        expect(dataLayerObject.ecommerce.item_list_name).to.equal(expectedDataLayer.ecommerce.item_list_name);
        expect(dataLayerObject.ecommerce.item_list_id).to.equal(expectedDataLayer.ecommerce.item_list_id);
        checkDataLayerItems(dataLayerObject, expectedDataLayer);
      });
    });
  });
});

describe('module: "Detail Page"', () => {
  it('checks the datalayer content', () => {
    cy.visit('/Variant-product/SWDEMO10005.5');
    cy.get('body').should('be.visible');

    cy.fixture('detail-page').then(expectedDataLayer => {
      cy.getDataLayerByEventName('view_item');
      cy.get('@dataLayerObject').then((dataLayerObject) => {
        expect(dataLayerObject).to.be.a('object');
        expect(dataLayerObject.event).to.equal(expectedDataLayer.event);
        expect(dataLayerObject.ecommerce.value).to.equal(expectedDataLayer.ecommerce.value);
        expect(dataLayerObject.ecommerce.currency).to.equal(expectedDataLayer.ecommerce.currency);
        checkDataLayerItems(dataLayerObject, expectedDataLayer);
      });
    });
  });
});
