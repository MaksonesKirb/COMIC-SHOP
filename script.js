if (document.getElementById('user_id')) {
    if (document.getElementById('user_id').textContent === 'empty') {
        cartArray = [];
        favArray = [];
        user_id = null;
    }
    } else {
        user_id = document.getElementById('user_id').textContent;
    }

    
if (!localStorage.getItem('orderinfo') || localStorage.getItem('orderinfo') === null) {
    localStorage.setItem('orderinfo', '[]');
}



let card = document.querySelectorAll('.my_card');

if (document.getElementById('userF')) {
if (document.getElementById('userF').textContent === 'empty') {
    favArray = [];
    console.log(favArray);
} else {
    favArray = (document.getElementById('userF').textContent).split(', ');
    console.log(favArray);
}}
if (document.getElementById('userC')) {
if (document.getElementById('userC').textContent === 'empty') {
    cartArray = [];
    console.log(cartArray)
} else {
    cartArray = (document.getElementById('userC').textContent).split(', ');
    console.log(cartArray)
}}




let favBtn = document.querySelectorAll('.like');
let buyBtn = document.querySelectorAll('.card_cart');
let heading = document.querySelector('.heading');
let container = document.querySelector('.container');

if (container) {
    for (i = 0; i < container.childElementCount; i++) {
        let cardID = card[i].getAttribute('data-id');
        if (buyBtn[0]){cartArray.includes(cardID) ? buyBtn[i].classList.add('cart_clicked') : buyBtn[i].classList.remove('cart_clicked')};
        if (favBtn[0]){favArray.includes(cardID) ? favBtn[i].classList.add('clicked') : favBtn[i].classList.remove('clicked')};

    }
};

$(document).on('click', '.card_cart', function() {
    let id_cart = $(this).attr('data-id');
    let index_cart = cartArray.indexOf(id_cart);
    $(this).toggleClass('cart_clicked');
    
    if (cartArray.includes(id_cart)) {
        cartArray.splice(index_cart, 1);
        // localStorage.setItem('cart', JSON.stringify(cartArray));
    } else {
        cartArray.unshift(id_cart);
        // localStorage.setItem('cart', JSON.stringify(cartArray));
    }

    $.ajax({
        url: "db.php",
        type: "POST",
        data: {
            checkout: JSON.stringify(cartArray),
        },
        success: (res) => {
          console.log(res);
        }
      });
});

if (document.querySelector('.count_btn') && user_id !== null) {
    let cartID = document.querySelector('.count_btn').getAttribute('data-id');
    favArray.includes(cartID) ? favBtn[0].classList.add('clicked') : favBtn[0].classList.remove('clicked');
    cartArray.includes(cartID) ? buyBtn[0].classList.add('cart_clicked') : buyBtn[0].classList.remove('cart_clicked');   
    cartArray.includes(cartID) ? buyBtn[0].textContent = 'В КОРЗИНЕ' : buyBtn[0].textContent = 'В КОРЗИНУ';
    
    $(document).on('click', '.count_btn', function() {
        cartArray.includes(cartID) ? buyBtn[0].textContent = 'В КОРЗИНЕ' : buyBtn[0].textContent = 'В КОРЗИНУ';
    })
};

$(document).on('click', '.like', function() {
    let id = $(this).attr('data-id');
    let index = favArray.indexOf(id);

    $(this).toggleClass('clicked');

    if (favArray.includes(id)) {
        favArray.splice(index, 1);
        // localStorage.setItem('favs', JSON.stringify(favArray));
    } else {
        favArray.unshift(id);
        // localStorage.setItem('favs', JSON.stringify(favArray));
    }


    $.ajax({
        url: "db.php",
        type: "POST",
        data: {
          checkoutfav: JSON.stringify(favArray),
        },
        success: (res) => {
          console.log(res);
        }
      });
});

$(document).on('click','#favor', function () {
    if (favArray.length === 0) {
        document.getElementById('myFavBtn').value = 'empty';
    } else {
        document.getElementById('myFavBtn').value = JSON.stringify(favArray);
    }
    document.getElementById('myForm').submit();
});

if (document.querySelector('.sorting')) {
    if (heading.textContent.includes('збранное') || heading.textContent.includes('не найдены')) {
        document.querySelector('.sorting').classList.add('hidden');
    } else {
        document.querySelector('.sorting').classList.remove('hidden');
    }
};

function cartForm () {if (cartArray.length === 0) {
        document.getElementById('myCartBtn').value = 'empty';
    } else {
        document.getElementById('myCartBtn').value = JSON.stringify(cartArray);
    }
    document.getElementById('myCartForm').submit();}


$(document).on('click', '.delete_btn', function() {
    let id_cart = $(this).attr('data-id');
    let index_cart = cartArray.indexOf(id_cart);

    cartArray.splice(index_cart, 1);
    $.ajax({
        url: "db.php",
        type: "POST",
        data: {
            checkout: JSON.stringify(cartArray),
        },
        success: (res) => {
          console.log(res);
        }
      });
    // localStorage.setItem('cart', JSON.stringify(cartArray));
    cartForm ();


});


$(document).on('click','#cart', function () {
    cartForm ();
});


$(document).on('click', '.pic', function() {
    document.getElementById("big-pic").src = $(this).attr('src');
});


$(document).on('click', '#desc_btn', function() { 
    document.querySelector('.description').classList.remove('hidden');
    document.querySelector('.parametr').classList.add('hidden');
    document.getElementById('param_btn').classList.remove('desc-param_active');
    document.getElementById('desc_btn').classList.add('desc-param_active');
});

$(document).on('click', '#param_btn', function() { 
    document.querySelector('.parametr').classList.remove('hidden');
    document.querySelector('.description').classList.add('hidden');
    document.getElementById('desc_btn').classList.remove('desc-param_active');
    document.getElementById('param_btn').classList.add('desc-param_active');
});

if (heading) {
    if (heading.textContent.includes('Вы пока ничего не добавили в корзину')) {
        document.querySelector('.total').classList.add('hidden');
    };
};


let totalPriceArray = [];
let totalPriceText = 0;

if (document.getElementById('myNewPrice')) {
    for (i = 0; i < cartArray.length; i++) {
        let getID = cartArray[i];
        let totalPrice = Number(document.querySelectorAll('#myNewPrice')[i].textContent);
        let count = 1;
        totalPriceArray.push({getID, totalPrice, count});
        localStorage.setItem('orderinfo', JSON.stringify(totalPriceArray));
    }
};

totalPriceArray.forEach((item) => {
    totalPriceText += item.totalPrice;
});

if (document.getElementById('total_price')) {
    document.getElementById('total_price').textContent = totalPriceText;
};

$(document).on('click', '#plus', function(){
    let currentValue = parseInt($(this).prev().val());
    let currentInput = $(this).prev().get(0);
    let getMaxCount = Number($(this).prev().attr('count'));
    
    if (currentValue >= 1) {
        currentValue += 1;
        currentInput.value = currentValue;
        document.getElementById('countBtn').value = currentValue;
    }
    
    if (currentValue >= getMaxCount) {
        currentInput.value = getMaxCount;
        currentValue = getMaxCount;
        $(this).attr('disabled', 'disabled');
    } else {
        $(this).removeAttr('disabled');
    }
    let getPrice = $(this).parent().prev().get(0).textContent;
    let totalPrice = getPrice * currentValue;
    let getID = $(this).attr('data-id');
    totalPriceText = 0;

    for (j = 0; j < totalPriceArray.length; j++) {
        if (totalPriceArray[j].getID === getID) {
            totalPriceArray[j].totalPrice = totalPrice;
            totalPriceArray[j].count = currentValue;
        }
    }
    totalPriceArray.forEach((item) => {
        totalPriceText += item.totalPrice;
    })
    document.getElementById('total_price').textContent = Number(totalPriceText).toLocaleString('ru-RU');
    localStorage.setItem('orderinfo', JSON.stringify(totalPriceArray));
});
    
$(document).on('click', '#minus', function(){
    let currentValue = parseInt($(this).next().val());
    let currentInput = $(this).next().get(0);
    let getMaxCount = Number($(this).next().attr('count'));
    
    if (currentValue > 1) {
        currentValue -= 1;
        currentInput.value = currentValue;
        document.getElementById('countBtn').value = currentValue;            
        $(this).next().next().removeAttr('disabled');
    }

    if (currentValue >= getMaxCount) {
        currentInput.value = getMaxCount;
        currentValue = getMaxCount;
    } 
    let getPrice = $(this).parent().prev().get(0).textContent;
    let totalPrice = getPrice * currentValue;
    let getID = $(this).attr('data-id');
    totalPriceText = 0;

    for (j = 0; j < totalPriceArray.length; j++) {
        if (totalPriceArray[j].getID === getID) {
            totalPriceArray[j].totalPrice = totalPrice;
            totalPriceArray[j].count = currentValue;
        }
    }
    totalPriceArray.forEach((item) => {
        totalPriceText += item.totalPrice;
    })
    document.getElementById('total_price').textContent = Number(totalPriceText).toLocaleString('ru-RU');
    localStorage.setItem('orderinfo', JSON.stringify(totalPriceArray));
});


$(document).on('input', '.counter_input', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
    let currentValue = parseInt($(this).val());
    let currentInput = $(this).get(0);
    let getMaxCount = Number($(this).attr('count'));

    if (this.value < 1) {
        currentValue = 1;
        currentInput.value = currentValue;
    }

    if (this.value > getMaxCount) {
        this.value = getMaxCount;
        currentValue = this.value;
    }

    let getPrice = $(this).parent().prev().get(0).textContent;
    let totalPrice = getPrice * currentValue;
    let getID = $(this).attr('data-id');
    totalPriceText = 0;

    for (j = 0; j < totalPriceArray.length; j++) {
        if (totalPriceArray[j].getID === getID) {
            totalPriceArray[j].totalPrice = totalPrice;
            totalPriceArray[j].count = currentValue;
        }
    }

    totalPriceArray.forEach((item) => {
        totalPriceText += item.totalPrice;
    })
    document.getElementById('total_price').textContent = Number(totalPriceText).toLocaleString('ru-RU');
    localStorage.setItem('orderinfo', JSON.stringify(totalPriceArray));
});

if (document.getElementById('total_price')) {
    document.getElementById('total_price').textContent = Number(totalPriceText).toLocaleString('ru-RU');
};


$(document).on('click', '.total_btn', function() {
    document.getElementById('confirmBtn').value = localStorage.getItem('orderinfo');
});

$(document).on('click', '#readyBtn', function() {
    document.querySelector('.ordersucces').classList.remove('hidden');
    setTimeout(function() {
        document.querySelector('.ordersucces').classList.add('hidden');
      }, 9000);
    $.ajax({
        url: "orderpage.php",
        type: "POST",
        data: {
            user_info: JSON.parse(localStorage.getItem('orderinfo')),
        },
        success: (res) => {
          console.log(res);
        }
      });
});

$(document).on('click', '#cancel', function() {
    let order_id= $(this).attr('order_id');
    let cancel='отменен';
    $.ajax({
        url: "profile.php",
        type: "POST",
        data: {
            cancel: cancel,
            order_id: order_id,
        },
        success: (res) => {
          console.log(res);
        }
      });
 $(this).addClass('hidden');
});

if (document.querySelector('.orders_card')){
    for (i = 0; i < document.querySelector('.myOrder').childElementCount; i++) {
if (document.querySelectorAll('#status')[i].textContent.includes('отменен')){
    document.querySelectorAll('#cancel')[i].classList.add('hidden');
}}}

//каталог
$(document).on('mouseenter', '.catalog', function() {
    $(document.querySelector('.formbtn')).css('display', 'block');
})

$(document).on('mouseleave', '.catalog', function() {
    $(document.querySelector('.formbtn')).css('display', 'none');
})

$(document).on('mouseenter', '.formbtn', function() {
    $(document.querySelector('.formbtn')).css('display', 'block');
})

$(document).on('mouseleave', '.formbtn', function() {
    $(document.querySelector('.formbtn')).css('display', 'none');
})

//сортировка
$(document).on('mouseenter', '.sorting', function() {
    $(document.querySelector('.formbtn2')).css('display', 'block');
})

$(document).on('mouseleave', '.sorting', function() {
    $(document.querySelector('.formbtn2')).css('display', 'none');
})

$(document).on('mouseenter', '.formbtn2', function() {
    $(document.querySelector('.formbtn2')).css('display', 'block');
})

$(document).on('mouseleave', '.formbtn2', function() {
    $(document.querySelector('.formbtn2')).css('display', 'none');
})