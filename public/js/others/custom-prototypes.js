/**
 * Check if object is empty
 * @return {Boolean}
 */
Object.defineProperty(Object.prototype, 'tmjIsEmpty', {
    value: function () {
        if (typeof this !== 'object' || this === null)
            return false;

        for (var prop in this) {
            if (this.hasOwnProperty(prop))
                return false;
        }

        return true;
    },
    enumerable: false
});

/**
 * Finds an object element from an Array or Array of Objects [{}]
 * @param {String} key (required)
 * @param {String} property (optional - finds value in array instead)
 * @return {Object}
 */
Object.defineProperty(Array.prototype, 'tmjFind', {
    value: function (key, property) {
        if (property == undefined) {
            // Find value in array
            return this.filter(function (val) {
                return val == key;
            })[0];
        }

        // Find value in array of objects
        return this.filter(function (obj) {
            if (obj.hasOwnProperty(property)) {
                return obj[property] == key;
            }
        })[0];
    },
    enumerable: false
});

/**
 * Finds the index of an element from an Array of Objects [{}]
 * @param {String} key (required)
 * @param {String} property (required)
 * @return {Number}
 */
 Object.defineProperty(Array.prototype, 'tmjIndexOfArrObj', {
    value: function (key, property) {
        return this.map(function(obj) {
            if(obj.hasOwnProperty(property)) {
                return obj[property];
            }
        }).indexOf(key);
    },
    enumerable: false
});

/**
 * Removes an element from an Array of Objects [{}]
 * @param {String} key (required)
 * @param {String} property (required)
 * @return {Object} obj
 */
Object.defineProperty(Array.prototype, 'tmjRemove', {
    value: function (key, property) {
        var index = this.tmjIndexOfArrObj(key, property);

        if (index <= -1) return null;

        var obj = this[index];
        this.splice(index, 1);
        return obj;
    },
    enumerable: false
});

/**
 * Concatenates hours and minutes from date instance
 * @param {String} timeFormat (optional - defaults to 24)
 * @return {String} time
 */
Date.prototype.tmjTime = function (timeFormat) {
    var hrs = this.getHours();
    var mins = ('0' + this.getMinutes()).slice(-2);
    var time = null;

    if (timeFormat === '24' || timeFormat === undefined) {
        hrs = ('0' + hrs).slice(-2);
        time = hrs + ':' + mins;
    } else if (timeFormat === '12') {
        var period = hrs >= 12 ? 'pm' : 'am';
        hrs = (hrs = hrs % 12) ? hrs : 12;
        hrs = ('0' + hrs).slice(-2);
        time = hrs + ':' + mins + period;
    } else {
        time = 'Invalid Time Format';
    }

    return time;
};

/**
 * Gets the 'GMT+{Timezone}' string from date instance
 * @return {String}
 */
Date.prototype.tmjGMT = function () {
    return this.toString().match(/([A-Z]+[\+-][0-9]+)/)[1];
};

/**
 * Gets the weekday with the format based on weekDay param
 * @param {String} locale (optional - defaults to undefined)
 * @param {String} weekDay (optional - defaults to short)
 * @return {String}
 */
Date.prototype.tmjWeekDay = function (locale, weekDay) {
    weekDay = weekDay === undefined ? 'short' : weekDay;
    return this.toLocaleDateString(locale, {weekday: weekDay})
};

/**
 * Builds a short date today format from date instance
 * @param {String} locale (optional - defaults to undefined)
 * @param {Object} opt (optional - defaults to undefined)
 * @param {String} opt.month (optional - defaults to short)
 * @param {String} opt.weekday (optional - defaults to undefined)
 * @return {String}
 */
Date.prototype.tmjToday = function (locale, withTime, opt) {
    var month = opt === undefined ? 'short' : (opt.month === undefined ? 'short' : opt.month);
    var weekday = opt === undefined ? undefined : opt.weekday;
    var options = {
        year: 'numeric', month: month,
        day: 'numeric', weekday: weekday
    };

    if (withTime) {
        options.hour = '2-digit';
        options.minute = '2-digit';
    }

    return this.toLocaleDateString(locale, options);
};
