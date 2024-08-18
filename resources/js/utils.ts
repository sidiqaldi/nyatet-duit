import { usePage } from "@inertiajs/vue3";
import { CurrencyDisplay, CurrencyInputOptions } from "vue-currency-input";

export const formatNumber = (number: number | null): string => {

    const currency = usePage().props.auth.user.currency;

    const locale = (usePage().props.auth.user.locale).replace(/\_/g, '-');

    if (number === null) {
        number = 0;
    }

    let formatCurrency = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency,
    });

    return formatCurrency.format(number);
};

export const getCurrencyOptions = (): CurrencyInputOptions => {
    const currency = usePage().props.auth.user.currency;

    const locale = (usePage().props.auth.user.locale).replace(/\_/g, '-');

    return {
        accountingSign: false,
        autoDecimalDigits: false,
        currency: currency,
        currencyDisplay: CurrencyDisplay.symbol,
        hideCurrencySymbolOnFocus: false,
        hideGroupingSeparatorOnFocus: false,
        locale: locale,
        hideNegligibleDecimalDigitsOnFocus: true,
        useGrouping: true,
    }
}