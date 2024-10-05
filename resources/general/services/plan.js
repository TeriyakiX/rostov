import bc from 'locutus/php/bc';

export const dailyProfitCount = (value, percent) => {
    const v =  bc.bcdiv(
        bc.bcmul(value, percent, 2),
        100,
        2
    );

    return parseFloat(v);
}

export const daysProfitCount = (value, percent, days) => {
    let v = 0;

    for (let i = 0; i < days; i++) v = bc.bcadd(
        v,
        bc.bcdiv(
            bc.bcmul(
                bc.bcadd(v, value, 2),
                percent,
                2
            ),
            100,
            2
        ),
        2
    );

    return parseFloat(v);
}

export const valueToUsd = (value, percent) => {
    const v = bc.bcmul(
        value,
        bc.bcdiv(
            1,
            percent,
            25
        ),
        2
    );

    return parseFloat(v);
}

export const usdToSpecialRate = (value, rate) => {
    const splitArray = rate.toString().split('.');

    if(splitArray.length === 2) {
        let length = splitArray[1].length;

        return bc.bcmul(value, rate, length - 1);
    } else {
        return bc.bcmul(value, rate, 2);
    }
}
