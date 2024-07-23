describe('Main page', () => {
    beforeEach(() => {
        cy.viewport(1920, 1000)
        cy.session('visit', () => {
            cy.visit('http://localhost/comics10/change.php')
        })
    })

    describe('Unauthorized user possibilities', () => {
        beforeEach(() => {
            cy.visit('http://localhost/comics10/main.php')
        })

        it('Using logo as link on main page', () => {
            cy.get('.logo').click()
            cy.get('.heading').should('text', 'Главная')
        })
    
        it('Using dropdown list of catalog', () => {
            cy.get('.header_center > form').eq(0).trigger('mouseover')
            cy.get('.formbtn > button').eq(6).click()
            cy.get('.heading').should('text', 'Альтернатива')
        })

        it('Using dropdown list of sorting', () => {
            cy.get('form').eq(2).trigger('mouseover')
            cy.get('.formbtn2 > button').eq(0).click()
        })

        it('Using search bar with successful result', () => {
            cy.get('.search > input').type('том' + '{enter}')
            cy.get('.heading').should('text', 'Результаты по запросу: том')
        })

        it('Using search bar with failed result', () => {
            cy.get('.search > input').type('халк' + '{enter}')
            cy.get('.heading').should('text', 'Результаты по запросу: халк не найдены')
        })

        it('Navigate to favorite page', () => {
            cy.get('.user-nav_link').eq(1).click()
            cy.get('.heading').should('text', 'Вы пока ничего не добавили в избранное')
        })

        it('Navigate to cart page', () => {
            cy.get('.user-nav_link').eq(2).click()
            cy.get('.heading').should('text', 'Вы пока ничего не добавили в корзину')
        })

        it('Navigate to authorization page using navigation', () => {
            cy.get('.user-nav_link').eq(0).click()
            cy.get('.modal_form > h1').should('text', 'Вход')
        })

        it('Navigate to product page using cover', () => {
            cy.get('.card_img').eq(0).click()
            cy.get('.information > h1').contains('Боун')
        })

        it('Navigate to product page using title', () => {
            cy.get('.card > a').eq(1).click()
            cy.get('.information > h1').contains('Боун')
        })

        it('Change', () => {
            cy.visit('http://localhost/comics10/product.php?id=1')
            cy.get('.desc_params_param').eq(1).click().should('have.class', 'desc-param_active')
            cy.get('.desc_params_param').eq(0).should('not.class', 'desc-param_active')
            cy.get('.description').should('have.class', 'hidden')
            cy.get('.parametr').should('not.class', 'hidden')
        })

        it('Navigate to authorization page using favorite button', () => {
            cy.get('.card_bottom > a').eq(0).click()
            cy.get('.modal_form > h1').should('text', 'Вход')
        })

        it('Navigate to authorization page using cart button', () => {
            cy.get('.card_bottom > a').eq(1).click()
            cy.get('.modal_form > h1').should('text', 'Вход')
        })
    })

    describe('Authorized user possibilities', () => {
        beforeEach(() => {
            cy.visit('http://localhost/comics10/login.php')
            cy.get('.modal_input > input').eq(0).clear().type('maksim@mail.ru')
            cy.get('.modal_input > input').eq(1).clear().type('123')
            cy.get('.modal_btn').click()
        })

        it('Update favorite using favorite button in product card', () => {
            if (cy.get('.fav_btn').eq(0).should('not.class', 'clicked')) {
                cy.get('.fav_btn').eq(0).click()
                cy.get('.fav_btn').eq(0).should('have.class', 'clicked')
            }

            if (cy.get('.fav_btn').eq(0).should('have.class', 'clicked')) {
                cy.get('.fav_btn').eq(0).click()
                cy.get('.fav_btn').eq(0).should('not.class', 'clicked')
            }
        })

        it('Update cart using cart button in product card', () => {
            if (cy.get('.card_cart').eq(0).should('not.class', 'cart_clicked')) {
                cy.get('.card_cart').eq(0).click()
                cy.get('.card_cart').eq(0).should('have.class', 'cart_clicked')
            }

            if (cy.get('.card_cart').eq(0).should('have.class', 'cart_clicked')) {
                cy.get('.card_cart').eq(0).click()
                cy.get('.card_cart').eq(0).should('not.class', 'cart_clicked')
            }
        })

        it('Update favorite using product page', () => {
            cy.visit('http://localhost/comics10/product.php?id=1')

            if (cy.get('.heart').should('not.class', 'clicked')) {
                cy.get('.heart').click()
                cy.get('.heart').should('have.class', 'clicked')
            }

            if (cy.get('.heart').should('have.class', 'clicked')) {
                cy.get('.heart').click()
                cy.get('.heart').should('not.class', 'clicked')
            }
        })

        it('Update cart using product page', () => {
            cy.visit('http://localhost/comics10/product.php?id=1')

            if (cy.get('.card_cart').should('not.class', 'cart_clicked')) {
                cy.get('.card_cart').click()
                cy.get('.card_cart').should('have.class', 'cart_clicked')
            }

            if (cy.get('.card_cart').should('have.class', 'cart_clicked')) {
                cy.get('.card_cart').click()
                cy.get('.card_cart').should('not.class', 'cart_clicked')
            }
        })
    })
})