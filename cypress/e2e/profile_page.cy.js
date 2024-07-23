describe('Tests', () => {
    beforeEach(() => {
        cy.viewport(1920, 1000)
        cy.session('visit', () => {
            cy.visit('http://localhost/comics10/change.php')
        })
    })

    describe('Profile page', () => {
        beforeEach(() => {
            cy.visit('http://localhost/comics10/login.php')
            cy.get('.modal_input > input').eq(0).clear().type('maksim@mail.ru')
            cy.get('.modal_input > input').eq(1).clear().type('123')
            cy.get('.modal_btn').click()
            cy.get('.user-nav_link').eq(0).click()
        })

        it('Log out', () => {
            cy.get('.user-nav_link').eq(0).click()
            cy.get('.modal_form > h1').should('text', 'Вход')
        })

        it('Cancel the order', () => {
            cy.get('.user-nav_link').eq(2).click()
            cy.get('.total_btn').click()
            cy.get('#readyBtn').click()
            cy.get('.user-nav_link').eq(0).click()
            cy.get('.cancel').eq(0).click()
            cy.reload()
            cy.get('#status').contains('отменен')
        })

        it('Navigate to change password page', () => {
            cy.get('.total > a').click()
            cy.get('.modal_form > h1').should('text', 'Смена пароля')
        })
    })
})