describe('Tests', () => {
    beforeEach(() => {
        cy.viewport(1920, 1000)
        cy.session('visit', () => {
            cy.visit('http://localhost/comics10/change.php')
        })
    })

    describe('Order page', () => {
        beforeEach(() => {
            cy.visit('http://localhost/comics10/login.php')
            cy.get('.modal_input > input').eq(0).clear().type('maksim@mail.ru')
            cy.get('.modal_input > input').eq(1).clear().type('123')
            cy.get('.modal_btn').click()
            cy.get('.user-nav_link').eq(2).click()
        })

        it('Check order accuracy', () => {
            cy.get('.container').should('have.prop', 'childElementCount', 3)
            cy.get('.heading').contains(3)
            cy.get('#plus').first().click()
            cy.get('.counter_input').last().type('{selectall}' + '4')
            cy.get('#total_price').contains('5 516')

            cy.get('.total_btn').click()

            cy.get('.h4').first().contains('2')
            cy.get('.h4').eq(1).contains('1')
            cy.get('.h4').last().contains('3')

            cy.get('.order-total > h2').last().contains('5 516')
        })
    })
})