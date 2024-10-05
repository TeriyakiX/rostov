import {price} from './price';
import {date, dateWithTime, dateWithSeconds} from './date';
import {days} from "./general";

export default (Vue) => {
    Vue.filter('price', price);

    Vue.filter('days', days);

    Vue.filter('date', date);
    Vue.filter('dateWithTime', dateWithTime);
    Vue.filter('dateWithSeconds', dateWithSeconds);
}
