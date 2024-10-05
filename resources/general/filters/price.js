const price = (value, currency = 'USD') => {
    const currencyList = ['USD', 'RUB'];

    if(currencyList.includes(currency.toUpperCase())) {
        return Intl.NumberFormat('ru', {
            style: 'currency',
            currency: currency
        }).format(value);
    } else {
        return value + ' ' + currency.toUpperCase();
    }
}

export {price};
