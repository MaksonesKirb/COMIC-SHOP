describe('Tests', () => {
    beforeEach(() => {
        cy.viewport(1920, 1000)
        cy.session('visit', () => {
            cy.visit('http://localhost/comics10/change.php')
        })
    })

    describe('Cart page', () => {
        beforeEach(() => {
            cy.visit('http://localhost/comics10/login.php')
            cy.get('.modal_input > input').eq(0).clear().type('maksim@mail.ru')
            cy.get('.modal_input > input').eq(1).clear().type('123')
            cy.get('.modal_btn').click()
            cy.get('.user-nav_link').eq(2).click()
        })

        it('Counter check', () => {
            cy.get('.container').should('have.prop', 'childElementCount', 3)
            cy.get('.heading').contains(3)
        })

        it('Navigate to product page using cover', () => {
            cy.get('.purchase_card > a').eq(0).click()
            cy.get('.information > h1').contains('Чародейки')
        })

        it('Navigate to product page using title', () => {
            cy.get('.card_title').eq(0).click()
            cy.get('.information > h1').contains('Чародейки')
        })

        it('Update favorite using favorite button', () => {
            if (cy.get('.fav_btn').eq(0).should('not.class', 'clicked')) {
                cy.get('.fav_btn').eq(0).click()
                cy.get('.fav_btn').eq(0).should('have.class', 'clicked')
            }
            
            if (cy.get('.fav_btn').eq(0).should('have.class', 'clicked')) {
                cy.get('.fav_btn').eq(0).click()
                cy.get('.fav_btn').eq(0).should('not.class', 'clicked')
            }
        })

        it('Remove product from cart', () => {
            cy.get('.logo').click()
            cy.get('.card_cart').first().click()
            cy.get('.user-nav_link').eq(2).click()
            cy.get('.container').should('have.prop', 'childElementCount', 4)
            cy.get('.heading').contains(4)
            cy.get('.delete_btn').first().click()
            cy.reload()
            cy.get('.container').should('have.prop', 'childElementCount', 3)
            cy.get('.heading').contains(3)
        })

        it('Navigate to checkout page', () => {
            cy.get('.total_btn').click()
            cy.get('.heading').contains('Оформление заказа')
        })

        describe('Counter', () => {
            it('Check default quantity value', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
            })

            it('Reducing quantity of product when input value = 1', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
                cy.get('#minus').first().click()
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
            })

            it('Reducing quantity of product when input value > 1', () => {
                cy.get('#plus').first().click()
                cy.get('.counter_input').first().invoke('val').should('equal', '2')
                cy.get('#minus').first().click()
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
            })

            it('Increasing quantity of product when input value = 1', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
                cy.get('#plus').first().click()
                cy.get('.counter_input').first().invoke('val').should('equal', '2')
            })

            it('Increasing quantity of product when input value = max value', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')

                for (let i = 0; i < 6; i++) {
                    cy.get('#plus').first().click()
                }

                cy.get('#plus').first().should('have.attr', 'disabled', 'disabled')
                cy.get('.counter_input').first().invoke('val').should('equal', '7')
            })

            it('Typing valid count', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
                cy.get('.counter_input').first().type('{selectall}' + '4')
                cy.get('.counter_input').first().invoke('val').should('equal', '4')
            })

            it('Typing count greater than max value', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
                cy.get('.counter_input').first().type('{selectall}' + '1000')
                cy.get('.counter_input').first().invoke('val').should('equal', '7')
            })

            it('Typing space character', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
                cy.get('.counter_input').first().type('{selectall}' + ' ')
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
            })

            it('Typing letter A', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
                cy.get('.counter_input').first().type('{selectall}' + 'a')
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
            })

            it('Typing 0', () => {
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
                cy.get('.counter_input').first().type('{selectall}' + '0')
                cy.get('.counter_input').first().invoke('val').should('equal', '1')
            })
        })
    })
})