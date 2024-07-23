describe('Tests', () => {
    beforeEach(() => {
        cy.viewport(1920, 1000)
        cy.session('visit', () => {
            cy.visit('http://localhost/comics10/change.php')
        })
    })

    describe('Authorization page', () => {
        beforeEach(() => {
            cy.visit('http://localhost/comics10/login.php')
        })

        it('Navigate to registration page', () => {
            cy.get('a').eq(0).click()
            cy.get('.modal_formsec > h1').should('text', 'Регистрация')
        })

        it('Navigate to change password page', () => {
            cy.get('a').eq(1).click()
            cy.get('.modal_form > h1').should('text', 'Смена пароля')
        })

        it('Input an incorrect email', () => {
            cy.get('.modal_input > input').eq(0).clear().type('test')
            cy.get('.modal_input > input').eq(1).clear().type('test')
            cy.get('.modal_btn').click()
            cy.get('.modal_form > h1').should('text', 'Вход')
        })

        it('Input an email of unregistered user', () => {
            cy.get('.modal_input > input').eq(0).clear().type('test@gmail.com')
            cy.get('.modal_input > input').eq(1).clear().type('test')
            cy.get('.modal_btn').click()
            cy.get('.modal_form > h1').should('text', 'Вход')
        })

        it('Input an incorrect password', () => {
            cy.get('.modal_input > input').eq(0).clear().type('maksim@mail.ru')
            cy.get('.modal_input > input').eq(1).clear().type('12345')
            cy.get('.modal_btn').click()
            cy.get('.modal_form > h1').should('text', 'Вход')
        })
    })
})