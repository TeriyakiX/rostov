import moment from 'moment';
import 'moment/locale/ru';

moment.locale('ru');

const date = (date) => {
    if(!date) return '';
    return moment.utc(date, 'YYYY-MM-DD HH:mm:ss').format('LL');
};

const dateWithTime = (date) => {
    if(!date) return '';
    return moment.utc(date, 'YYYY-MM-DD HH:mm:ss').format('DD.MM.YYYY, HH:mm');
};

const dateWithSeconds = (date) => {
    if(!date) return '';
    return moment.utc(date, 'YYYY-MM-DD HH:mm:ss').format('DD.MM.YYYY, HH:mm:ssA');
};

const ago = date => {
    if(!date) return '';
    return moment.utc(date, 'YYYY-MM-DD HH:mm:ss').fromNow();
}

export {date, dateWithTime, dateWithSeconds, ago}
