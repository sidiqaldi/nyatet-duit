import { usePage } from "@inertiajs/vue3";

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