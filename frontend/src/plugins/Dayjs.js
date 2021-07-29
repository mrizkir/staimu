import Vue from "vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import isBetween from "dayjs/plugin/isBetween";
dayjs.extend(relativeTime);
dayjs.extend(isBetween);

Object.defineProperties(Vue.prototype, {
	$date: {
		get() {
			return dayjs;
		},
	},
});
