describe('Tests', () => {
    beforeEach(() => {
        cy.viewport(1920, 1000)
        cy.session('visit', () => {
            cy.visit('http://localhost/comics10/change.php')
        })
    })

    describe('Registration page', () => {
        beforeEach(() => {
            cy.visit('http://localhost/comics10/register.php')
        })

        it('Input an incorrect email', () => {
            cy.get('.modal_input > input').eq(0).clear().type('test')
            cy.get('.modal_input > input').eq(1).clear().type('test')
            cy.get('.modal_input > input').eq(2).clear().type('test')
            cy.get('.modal_btn').click()
            cy.get('.modal_formsec > h1').should('text', 'Регистрация')
        })

        it('Input an email of registered user', () => {
            cy.get('.modal_input > input').eq(0).clear().type('test')
            cy.get('.modal_input > input').eq(1).clear().type('maksim@mail.ru')
            cy.get('.modal_input > input').eq(2).clear().type('test')
            cy.get('.modal_btn').click()
            cy.get('.modal_formsec > h1').should('text', 'Регистрация')
        })
    })
})