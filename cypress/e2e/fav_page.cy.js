describe('Tests', () => {
    beforeEach(() => {
        cy.viewport(1920, 1000)
        cy.session('visit', () => {
            cy.visit('http://localhost/comics10/change.php')
        })
    })

    describe('Favorite page', () => {
        beforeEach(() => {
            cy.visit('http://localhost/comics10/login.php')
            cy.get('.modal_input > input').eq(0).clear().type('maksim@mail.ru')
            cy.get('.modal_input > input').eq(1).clear().type('123')
            cy.get('.modal_btn').click()
            cy.get('.user-nav_link').eq(1).click()
        })

        it('Counter check', () => {
            cy.get('.container').should('have.prop', 'childElementCount', 3)
            cy.get('.heading').contains(3)
        })
    })
})