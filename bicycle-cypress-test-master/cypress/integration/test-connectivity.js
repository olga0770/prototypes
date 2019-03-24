

let url = 'http://bicycle.test';

describe('Checking connectivity of the Bicycle site', function() {

    it('Visits app page', function() {
        cy.visit(url +  '/bikes/1')
        cy.visit(url +  '/bikes/2')
    }),

    it('Can select a bike in the UI', function() {
        cy.visit(url);
        cy.contains('MTB').click()
        cy.get('li').first().its('text').should('not.be.empty');
        cy.contains('Serial')
    })
});