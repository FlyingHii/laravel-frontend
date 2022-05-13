<?php

namespace Manifera\Core;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
//use Manifera\Attribute\Repositories\AttributeOptionRepository;
//use Manifera\Category\Repositories\CategoryRepository;
//use Manifera\Category\Repositories\CategoryTranslationsRepository;
//use Manifera\Core\Models\Channel;
//use Manifera\Core\Repositories\ChannelRepository;
//use Manifera\Core\Repositories\CoreConfigRepository;
//use Manifera\Core\Repositories\CountryRepository;
//use Manifera\Core\Repositories\CountryStateRepository;
//use Manifera\Core\Repositories\CurrencyRepository;
//use Manifera\Core\Repositories\ExchangeRateRepository;
//use Manifera\Core\Repositories\LocaleRepository;
//use Manifera\Customer\Repositories\CustomerGroupRepository;
//use Manifera\Product\Repositories\ProductFlatRepository;
//use Manifera\Sale\Models\OrderItem;
//use Manifera\Sale\Repositories\OrderItemRepository;

class Core
{
    const CURRENCY_CODE_LABELS = [
        'SGD' => 'S$',
        'USD' => '$',
        'VND' => 'đ',
    ];

    /**
     * ChannelRepository class
     *
     * @var \Manifera\Core\Repositories\ChannelRepository
     */
    protected $channelRepository;

    /**
     * CurrencyRepository class
     *
     * @var \Manifera\Core\Repositories\CurrencyRepository
     */
    protected $currencyRepository;

    /**
     * ExchangeRateRepository class
     *
     * @var \Manifera\Core\Repositories\ExchangeRateRepository
     */
    protected $exchangeRateRepository;

    /**
     * CountryRepository class
     *
     * @var \Manifera\Core\Repositories\CountryRepository
     */
    protected $countryRepository;

    /**
     * CountryStateRepository class
     *
     * @var \Manifera\Core\Repositories\CountryStateRepository
     */
    protected $countryStateRepository;

    /**
     * LocaleRepository class
     *
     * @var \Manifera\Core\Repositories\LocaleRepository
     */
    protected $localeRepository;

    /**
     * CustomerGroupRepository class
     *
     * @var CustomerGroupRepository
     */
    protected $customerGroupRepository;

    /**
     * CoreConfigRepository class
     *
     * @var \Manifera\Core\Repositories\CoreConfigRepository
     */
    protected $coreConfigRepository;

    /** @var Channel */
    private static $channel;

    /**
     * Create a new instance.
     *
     * @param \Manifera\Core\Repositories\ChannelRepository       $channelRepository
     * @param \Manifera\Core\Repositories\CurrencyRepository      $currencyRepository
     * @param \Manifera\Core\Repositories\ExchangeRateRepository  $exchangeRateRepository
     * @param \Manifera\Core\Repositories\CountryRepository       $countryRepository
     * @param \Manifera\Core\Repositories\CountryStateRepository  $countryStateRepository
     * @param \Manifera\Core\Repositories\LocaleRepository        $localeRepository
     * @param \Manifera\Core\Repositories\CustomerGroupRepository $customerGroupRepository
     * @param \Manifera\Core\Repositories\CoreConfigRepository    $coreConfigRepository
     *
     * @return void
     */
    public function __construct(
//        ChannelRepository $channelRepository,
//        CurrencyRepository $currencyRepository,
//        ExchangeRateRepository $exchangeRateRepository,
//        CountryRepository $countryRepository,
//        CountryStateRepository $countryStateRepository,
//        LocaleRepository $localeRepository,
//        CustomerGroupRepository $customerGroupRepository,
//        CoreConfigRepository $coreConfigRepository
    ) {
//        $this->channelRepository = $channelRepository;
//
//        $this->currencyRepository = $currencyRepository;
//
//        $this->exchangeRateRepository = $exchangeRateRepository;
//
//        $this->countryRepository = $countryRepository;
//
//        $this->countryStateRepository = $countryStateRepository;
//
//        $this->localeRepository = $localeRepository;
//
//        $this->customerGroupRepository = $customerGroupRepository;
//
//        $this->coreConfigRepository = $coreConfigRepository;
    }

    /**
     * Returns all channels
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllChannels()
    {
        static $channels;

        if ($channels) {
            return $channels;
        }

        return $channels = $this->channelRepository->all();
    }

    /**
     * Returns currenct channel models
     *
     * @return \Manifera\Core\Contracts\Channel
     */
    public function getCurrentChannel()
    {
        if (self::$channel) {
            return self::$channel;
        }

        self::$channel = $this->channelRepository->findWhereIn('hostname', [
            request()->getHttpHost(),
            'http://' . request()->getHttpHost(),
            'https://' . request()->getHttpHost(),
        ])->first();

        if (!self::$channel) {
            self::$channel = $this->channelRepository->first();
        }

        return self::$channel;
    }

    /**
     * Set the current channel
     *
     * @param Channel $channel
     */
    public function setCurrentChannel(Channel $channel): void
    {
        self::$channel = $channel;
    }

    /**
     * Returns currenct channel code
     *
     * @return \Manifera\Core\Contracts\Channel
     */
    public function getCurrentChannelCode(): string
    {
        static $channelCode;

        if ($channelCode) {
            return $channelCode;
        }

        return ($channel = $this->getCurrentChannel()) ? $channelCode = $channel->code : '';
    }

    /**
     * Returns default channel models
     *
     * @return \Manifera\Core\Contracts\Channel
     */
    public function getDefaultChannel(): ?Channel
    {
        static $channel;

        if ($channel) {
            return $channel;
        }

        $channel = $this->channelRepository->findOneByField('code', config('app.channel'));

        if ($channel) {
            return $channel;
        }

        return $channel = $this->channelRepository->first();
    }

    /**
     * Returns the default channel code configured in config/app.php
     *
     * @return string
     */
    public function getDefaultChannelCode(): string
    {
        static $channelCode;

        if ($channelCode) {
            return $channelCode;
        }

        return ($channel = $this->getDefaultChannel()) ? $channelCode = $channel->code : '';
    }

    /**
     * Returns all locales
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllLocales()
    {
        static $locales;

        if ($locales) {
            return $locales;
        }

        return $locales = $this->localeRepository->all();
    }

    /**
     * Returns current locale
     *
     * @return \Manifera\Core\Contracts\Locale
     */
    public function getCurrentLocale()
    {
        static $locale;

        if ($locale) {
            return $locale;
        }

        $locale = $this->localeRepository->findOneByField('code', app()->getLocale());

        if (!$locale) {
            $locale = $this->localeRepository->findOneByField('code', config('app.fallback_locale'));
        }

        return $locale;
    }

    /**
     * Returns all Customer Groups
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllCustomerGroups()
    {
        static $customerGroups;

        if ($customerGroups) {
            return $customerGroups;
        }

        return $customerGroups = $this->customerGroupRepository->all();
    }

    /**
     * Returns all currencies
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllCurrencies()
    {
        static $currencies;

        if ($currencies) {
            return $currencies;
        }

        return $currencies = $this->currencyRepository->all();
    }

    /**
     * Returns base channel's currency model
     *
     * @return \Manifera\Core\Contracts\Currency
     */
    public function getBaseCurrency()
    {
        static $currency;

        if ($currency) {
            return $currency;
        }

        $baseCurrency = $this->currencyRepository->findOneByField('code', config('app.currency'));

        if (!$baseCurrency) {
            $baseCurrency = $this->currencyRepository->first();
        }

        return $currency = $baseCurrency;
    }

    /**
     * Returns base channel's currency code
     *
     * @return string
     */
    public function getBaseCurrencyCode()
    {
        static $currencyCode;

        if ($currencyCode) {
            return $currencyCode;
        }

        return ($currency = $this->getBaseCurrency()) ? $currencyCode = $currency->code : '';
    }

    /**
     * Returns base channel's currency model
     *
     * @return \Manifera\Core\Contracts\Currency
     */
    public function getChannelBaseCurrency()
    {
        static $currency;

        if ($currency) {
            return $currency;
        }

        $currenctChannel = $this->getCurrentChannel();

        return $currency = $currenctChannel->base_currency;
    }

    /**
     * Returns base channel's currency code
     *
     * @return string
     */
    public function getChannelBaseCurrencyCode()
    {
        static $currencyCode;

        if ($currencyCode) {
            return $currencyCode;
        }

        return ($currency = $this->getChannelBaseCurrency()) ? $currencyCode = $currency->code : '';
    }

    /**
     * Returns current channel's currency model
     *
     * @return \Manifera\Core\Contracts\Currency
     */
    public function getCurrentCurrency()
    {
        static $currency;

        if ($currency) {
            return $currency;
        }

        if ($currencyCode = session()->get('currency')) {
            if ($currency = $this->currencyRepository->findOneByField('code', $currencyCode)) {
                return $currency;
            }
        }

        return $currency = $this->getChannelBaseCurrency();
    }

    /**
     * Returns current channel's currency code
     *
     * @return string
     */
    public function getCurrentCurrencyCode()
    {
        static $currencyCode;

        if ($currencyCode) {
            return $currencyCode;
        }

        return ($currency = $this->getCurrentCurrency()) ? $currencyCode = $currency->code : '';
    }

    /**
     * Converts price
     *
     * @param float  $amount
     * @param string $targetCurrencyCode
     * @param string $orderCurrencyCode
     *
     * @return string
     */
    public function convertPrice($amount, $targetCurrencyCode = null, $orderCurrencyCode = null)
    {
        if (!isset($this->lastCurrencyCode)) {
            $this->lastCurrencyCode = $this->getBaseCurrency()->code;
        }

        if ($orderCurrencyCode) {
            if (!isset($this->lastOrderCode)) {
                $this->lastOrderCode = $orderCurrencyCode;
            }

            if (($targetCurrencyCode != $this->lastOrderCode)
                && ($targetCurrencyCode != $orderCurrencyCode)
                && ($orderCurrencyCode != $this->getBaseCurrencyCode())
                && ($orderCurrencyCode != $this->lastCurrencyCode)
            ) {
                $amount = $this->convertToBasePrice($amount, $orderCurrencyCode);
            }
        }

        $targetCurrency = !$targetCurrencyCode
        ? $this->getCurrentCurrency()
        : $this->currencyRepository->findOneByField('code', $targetCurrencyCode);

        if (!$targetCurrency) {
            return $amount;
        }

        $exchangeRate = $this->exchangeRateRepository->findOneWhere([
            'target_currency' => $targetCurrency->id,
        ]);

        if (null === $exchangeRate || !$exchangeRate->rate) {
            return $amount;
        }

        $result = (float) $amount * (float) ($this->lastCurrencyCode == $targetCurrency->code ? 1.0 : $exchangeRate->rate);

        if ($this->lastCurrencyCode != $targetCurrency->code) {
            $this->lastCurrencyCode = $targetCurrency->code;
        }

        return $result;
    }

    /**
     * Converts to base price
     *
     * @param float  $amount
     * @param string $targetCurrencyCode
     *
     * @return string
     */
    public function convertToBasePrice($amount, $targetCurrencyCode = null)
    {
        $targetCurrency = !$targetCurrencyCode
        ? $this->getCurrentCurrency()
        : $this->currencyRepository->findOneByField('code', $targetCurrencyCode);

        if (!$targetCurrency) {
            return $amount;
        }

        $exchangeRate = $this->exchangeRateRepository->findOneWhere([
            'target_currency' => $targetCurrency->id,
        ]);

        if (null === $exchangeRate || !$exchangeRate->rate) {
            return $amount;
        }

        return (float) $amount / $exchangeRate->rate;
    }

    /**
     * Format and convert price with currency symbol
     *
     * @param float $price
     *
     * @return string
     */
    public function currency($amount = 0)
    {
        if (is_null($amount)) {
            $amount = 0;
        }

        return $this->formatPrice($this->convertPrice($amount), $this->getCurrentCurrency()->code);
    }

    /**
     * Return currency symbol from currency code
     *
     * @param float $price
     *
     * @return string
     */
    public function currencySymbol($code)
    {
        $formatter = new \NumberFormatter(app()->getLocale() . '@currency=' . $code, \NumberFormatter::CURRENCY);

        $symbol = $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);

        return self::CURRENCY_CODE_LABELS[$symbol] ?? $symbol;
    }

    /**
     * Format and convert price with currency symbol
     *
     * @param float $price
     *
     * @return string
     */
    public function formatPrice($price, $currencyCode)
    {
        if (is_null($price)) {
            $price = 0;
        }

        $formatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::CURRENCY);
        $formatter->setTextAttribute(\NumberFormatter::CURRENCY_CODE, $currencyCode);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);

        $currency = $formatter->format($price);

        return str_replace($currencyCode, self::CURRENCY_CODE_LABELS[$currencyCode], $currency);
    }

    /**
     * Format and convert price with currency symbol
     *
     * @return array
     */
    public function getAccountJsSymbols()
    {
        $formater = new \NumberFormatter(app()->getLocale(), \NumberFormatter::CURRENCY);

        $pattern = $formater->getPattern();

        $pattern = str_replace("¤", "%s", $pattern);

        $pattern = str_replace("#,##0.00", "%v", $pattern);

        return [
            'symbol'  => core()->currencySymbol(core()->getCurrentCurrencyCode()),
            'decimal' => $formater->getSymbol(\NumberFormatter::DECIMAL_SEPARATOR_SYMBOL),
            'format'  => $pattern,
        ];
    }

    /**
     * Format price with base currency symbol
     *
     * @param float $price
     *
     * @return string
     */
    public function formatBasePrice($price)
    {
        if (is_null($price)) {
            $price = 0;
        }

        $formater = new \NumberFormatter(app()->getLocale(), \NumberFormatter::CURRENCY);

        if ($symbol = $this->getBaseCurrency()->symbol) {
            if ($this->currencySymbol($this->getBaseCurrencyCode()) == $symbol) {
                $formater->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, $symbol);

                return $formater->formatCurrency($price, $this->getBaseCurrencyCode());
            } else {
                $formater->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, $symbol);

                return $formater->format($this->convertPrice($price));
            }
        } else {
            return $formater->formatCurrency($price, $this->getBaseCurrencyCode());
        }
    }

    /**
     * Checks if current date of the given channel (in the channel timezone) is within the range
     *
     * @param int|string|\Manifera\Core\Contracts\Channel $channel
     * @param string|null                               $dateFrom
     * @param string|null                               $dateTo
     *
     * @return bool
     */
    public function isChannelDateInInterval($dateFrom = null, $dateTo = null)
    {
        $channel = $this->getCurrentChannel();

        $channelTimeStamp = $this->channelTimeStamp($channel);

        $fromTimeStamp = strtotime($dateFrom);

        $toTimeStamp = strtotime($dateTo);

        if ($dateTo) {
            $toTimeStamp += 86400;
        }

        if (!$this->is_empty_date($dateFrom) && $channelTimeStamp < $fromTimeStamp) {
            $result = false;
        } elseif (!$this->is_empty_date($dateTo) && $channelTimeStamp > $toTimeStamp) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    /**
     * Get channel timestamp, timstamp will be builded with channel timezone settings
     *
     * @param \Manifera\Core\Contracts\Channel $channel
     *
     * @return  int
     */
    public function channelTimeStamp($channel)
    {
        $timezone = $channel->timezone;

        $currentTimezone = @date_default_timezone_get();

        @date_default_timezone_set($timezone);

        $date = date('Y-m-d H:i:s');

        @date_default_timezone_set($currentTimezone);

        return strtotime($date);
    }

    /**
     * Check whether sql date is empty
     *
     * @param string $date
     *
     * @return bool
     */
    public function is_empty_date($date)
    {
        return preg_replace('#[ 0:-]#', '', $date) === '';
    }

    /**
     * Format date using current channel.
     *
     * @param \Illuminate\Support\Carbon|null $date
     * @param string                          $format
     *
     * @return  string
     */
    public function formatDate($date = null, $format = 'd-m-Y H:i:s')
    {
        $channel = $this->getCurrentChannel();

        if (is_null($date)) {
            $date = Carbon::now();
        }

        $date->setTimezone($channel->timezone);

        return $date->format($format);
    }

    /**
     * Retrieve information from payment configuration
     *
     * @param string          $field
     * @param int|string|null $channelId
     * @param string|null     $locale
     *
     * @return mixed
     */
    public function getConfigData($field, $channel = null, $locale = null)
    {
        if (null === $channel) {
            $channel = request()->get('channel') ?: ($this->getCurrentChannelCode() ?: $this->getDefaultChannelCode());
        }

        if (null === $locale) {
            $locale = request()->get('locale') ?: app()->getLocale();
        }

        $fields = $this->getConfigField($field);

        $channel_based = false;
        $locale_based  = false;

        if (isset($fields['channel_based']) && $fields['channel_based']) {
            $channel_based = true;
        }

        if (isset($fields['locale_based']) && $fields['locale_based']) {
            $locale_based = true;
        }

        if (isset($fields['channel_based']) && $fields['channel_based']) {
            if (isset($fields['locale_based']) && $fields['locale_based']) {
                $coreConfigValue = $this->coreConfigRepository->findOneWhere([
                    'code'         => $field,
                    'channel_code' => $channel,
                    'locale_code'  => $locale,
                ]);
            } else {
                $coreConfigValue = $this->coreConfigRepository->findOneWhere([
                    'code'         => $field,
                    'channel_code' => $channel,
                ]);
            }
        } else {
            if (isset($fields['locale_based']) && $fields['locale_based']) {
                $coreConfigValue = $this->coreConfigRepository->findOneWhere([
                    'code'        => $field,
                    'locale_code' => $locale,
                ]);
            } else {
                $coreConfigValue = $this->coreConfigRepository->findOneWhere([
                    'code' => $field,
                ]);
            }
        }

        if (!$coreConfigValue) {
            $fields = explode(".", $field);

            array_shift($fields);

            $field = implode(".", $fields);

            return Config::get($field);
        }

        return $coreConfigValue->value;
    }

    /**
     * Retrieve a group of information from the core config table
     *
     * @param mixed $criteria
     *
     * @return mixed
     */
    public function retrieveGroupConfig($criteria)
    {
        return $criteria;
    }

    /**
     * Retrieve all countries
     *
     * @return \Illuminate\Support\Collection
     */
    public function countries()
    {
        return $this->countryRepository->all();
    }

    /**
     * Returns country name by code
     *
     * @param string $code
     *
     * @return string
     */
    public function country_name($code)
    {
        $country = $this->countryRepository->findOneByField('code', $code);

        return $country ? $country->name : '';
    }

    /**
     * Retrieve all country states
     *
     * @param string $countryCode
     *
     * @return \Illuminate\Support\Collection
     */
    public function states($countryCode)
    {
        return $this->countryStateRepository->findByField('country_code', $countryCode);
    }

    /**
     * Retrieve all grouped states by country code
     *
     * @return \Illuminate\Support\Collection
     */
    public function groupedStatesByCountries()
    {
        $collection = [];

        foreach ($this->countryStateRepository->all() as $state) {
            $collection[$state->country_code][] = $state->toArray();
        }

        return $collection;
    }

    /**
     * Retrieve all grouped states by country code
     *
     * @return \Illuminate\Support\Collection
     */
    public function findStateByCountryCode($countryCode = null, $stateCode = null)
    {
        $collection = array();

        $collection = $this->countryStateRepository->findByField(['country_code' => $countryCode, 'code' => $stateCode]);

        if (count($collection)) {
            return $collection->first();
        } else {
            return false;
        }
    }

    /**
     * Returns time intervals
     *
     * @param \Illuminate\Support\Carbon $startDate
     * @param \Illuminate\Support\Carbon $endDate
     *
     * @return array
     */
    public function getTimeInterval($startDate, $endDate)
    {
        $timeIntervals = [];

        $totalDays   = $startDate->diffInDays($endDate) + 1;
        $totalMonths = $startDate->diffInMonths($endDate) + 1;

        $startWeekDay = Carbon::createFromTimeString($this->xWeekRange($startDate, 0) . ' 00:00:01');
        $endWeekDay   = Carbon::createFromTimeString($this->xWeekRange($endDate, 1) . ' 23:59:59');
        $totalWeeks   = $startWeekDay->diffInWeeks($endWeekDay);

        if ($totalMonths > 5) {
            for ($i = 0; $i < $totalMonths; $i++) {
                $date = clone $startDate;
                $date->addMonths($i);

                $start = Carbon::createFromTimeString($date->format('Y-m-d') . ' 00:00:01');
                $end   = $totalMonths - 1 == $i
                ? $endDate
                : Carbon::createFromTimeString($date->format('Y-m-d') . ' 23:59:59');

                $timeIntervals[] = ['start' => $start, 'end' => $end, 'formatedDate' => $date->format('M')];
            }
        } elseif ($totalWeeks > 6) {
            for ($i = 0; $i < $totalWeeks; $i++) {
                $date = clone $startDate;
                $date->addWeeks($i);

                $start = $i == 0
                ? $startDate
                : Carbon::createFromTimeString($this->xWeekRange($date, 0) . ' 00:00:01');
                $end = $totalWeeks - 1 == $i
                ? $endDate
                : Carbon::createFromTimeString($this->xWeekRange($date, 1) . ' 23:59:59');

                $timeIntervals[] = ['start' => $start, 'end' => $end, 'formatedDate' => $date->format('d M')];
            }
        } else {
            for ($i = 0; $i < $totalDays; $i++) {
                $date = clone $startDate;
                $date->addDays($i);

                $start = Carbon::createFromTimeString($date->format('Y-m-d') . ' 00:00:01');
                $end   = Carbon::createFromTimeString($date->format('Y-m-d') . ' 23:59:59');

                $timeIntervals[] = ['start' => $start, 'end' => $end, 'formatedDate' => $date->format('d M')];
            }
        }

        return $timeIntervals;
    }

    /**
     *
     * @param string $date
     * @param int    $day
     *
     * @return string
     */
    public function xWeekRange($date, $day)
    {
        $ts = strtotime($date);

        if (!$day) {
            $start = (date('D', $ts) == 'Sun') ? $ts : strtotime('last sunday', $ts);

            return date('Y-m-d', $start);
        } else {
            $end = (date('D', $ts) == 'Sat') ? $ts : strtotime('next saturday', $ts);

            return date('Y-m-d', $end);
        }
    }

    /**
     * Method to sort through the acl items and put them in order
     *
     * @param array $items
     *
     * @return array
     */
    public function sortItems($items)
    {
        foreach ($items as &$item) {
            if (count($item['children'])) {
                $item['children'] = $this->sortItems($item['children']);
            }
        }

        usort($items, function ($a, $b) {
            if ($a['sort'] == $b['sort']) {
                return 0;
            }

            return ($a['sort'] < $b['sort']) ? -1 : 1;
        });

        return $this->convertToAssociativeArray($items);
    }

    /**
     * @param string $fieldName
     *
     * @return array
     */
    public function getConfigField($fieldName)
    {
        foreach (config('core') as $coreData) {
            if (isset($coreData['fields'])) {
                foreach ($coreData['fields'] as $field) {
                    $name = $coreData['key'] . '.' . $field['name'];

                    if ($name == $fieldName) {
                        return $field;
                    }
                }
            }
        }
    }

    /**
     * @param array $items
     *
     * @return array
     */
    public function convertToAssociativeArray($items)
    {
        foreach ($items as $key1 => $level1) {
            unset($items[$key1]);
            $items[$level1['key']] = $level1;

            if (count($level1['children'])) {
                foreach ($level1['children'] as $key2 => $level2) {
                    $temp2     = explode('.', $level2['key']);
                    $finalKey2 = end($temp2);
                    unset($items[$level1['key']]['children'][$key2]);
                    $items[$level1['key']]['children'][$finalKey2] = $level2;

                    if (count($level2['children'])) {
                        foreach ($level2['children'] as $key3 => $level3) {
                            $temp3     = explode('.', $level3['key']);
                            $finalKey3 = end($temp3);
                            unset($items[$level1['key']]['children'][$finalKey2]['children'][$key3]);
                            $items[$level1['key']]['children'][$finalKey2]['children'][$finalKey3] = $level3;
                        }
                    }

                }
            }
        }

        return $items;
    }

    /**
     * @param array            $items
     * @param string           $key
     * @param string|int|float $value
     *
     * @return array
     */
    public function array_set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys  = explode('.', $key);
        $count = count($keys);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $finalKey = array_shift($keys);

        if (isset($array[$finalKey])) {
            $array[$finalKey] = $this->arrayMerge($array[$finalKey], $value);
        } else {
            $array[$finalKey] = $value;
        }

        return $array;
    }

    /**
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    protected function arrayMerge(array &$array1, array &$array2)
    {
        $merged = $array1;

        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->arrayMerge($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    /**
     * @param array $array1
     *
     * @return array
     */
    public function convertEmptyStringsToNull($array)
    {
        foreach ($array as $key => $value) {
            if ($value == "" || $value == "null") {
                $array[$key] = null;
            }
        }

        return $array;
    }

    /**
     * Create singletom object through single facade
     *
     * @param string $className
     *
     * @return object
     */
    public function getSingletonInstance($className)
    {
        static $instance = [];

        if (array_key_exists($className, $instance)) {
            return $instance[$className];
        }

        return $instance[$className] = app($className);
    }

    /**
     * Returns a string as selector part for identifying elements in views
     *
     * @param float $taxRate
     *
     * @return string
     */
    public static function taxRateAsIdentifier(float $taxRate): string
    {
        return str_replace('.', '_', (string) $taxRate);
    }

    /**
     * Get Shop email sender details
     *
     * @return array
     */
    public function getSenderEmailDetails()
    {
        $sender_name = core()->getConfigData('general.general.email_settings.sender_name') ? core()->getConfigData('general.general.email_settings.sender_name') : config('mail.from.name');

        $sender_email = core()->getConfigData('general.general.email_settings.shop_email_from') ? core()->getConfigData('general.general.email_settings.shop_email_from') : config('mail.from.address');

        return [
            'name'  => $sender_name,
            'email' => $sender_email,
        ];
    }

    /**
     * Get Admin email details
     *
     * @return array
     */
    public function getAdminEmailDetails()
    {
        $admin_name = core()->getConfigData('general.general.email_settings.admin_name') ? core()->getConfigData('general.general.email_settings.admin_name') : config('mail.admin.name');

        $admin_email = core()->getConfigData('general.general.email_settings.admin_email') ? core()->getConfigData('general.general.email_settings.admin_email') : config('mail.admin.address');

        return [
            'name'  => $admin_name,
            'email' => $admin_email,
        ];
    }

    /**
     * Format product by locale
     *
     * @param object $order_item
     * @return object
     */
    public function formatByLocale($order_item, $locale)
    {
        $attribute_options_unit_per_uom = app(AttributeOptionRepository::class)->scopeQuery(function ($query) {
            return $query
                ->select('attribute_options.*')
                ->join('attributes', 'attribute_options.attribute_id', '=', 'attributes.id')
                ->where('attributes.code', 'unit_per_uom');
        })->get();

        $product_additional_default = app(OrderItemRepository::class)->getAdditionalProduct($order_item, 'en');
        $product_additional         = app(OrderItemRepository::class)->getAdditionalProduct($order_item, $locale);

        if (isset($product_additional) && !empty($product_additional)) {
            $order_item->name = isset($product_additional['name']) ? $product_additional['name'] : $order_item->name;

            if (isset($order_item->uom_type)) {
                $order_item->uom_type = isset($product_additional['uom_type_label']) ? $product_additional['uom_type_label'] : $order_item->uom_type;
            }

            if (isset($order_item->unit_per_uom)) {
                $unit_per_uom_label       = isset($product_additional_default['unit_per_uom_label']) ? $product_additional_default['unit_per_uom_label'] : $order_item->unit_per_uom;
                $order_item->unit_per_uom = core()->formatUnitPerUom($unit_per_uom_label, $attribute_options_unit_per_uom);
            }
        }

        return $order_item;
    }

    /**
     * Format product by locale
     *
     * @param array $order_item
     * @return array
     */
    public function formatByLocaleArray($order_item, $locale)
    {
        $attribute_options_unit_per_uom = app(AttributeOptionRepository::class)->scopeQuery(function ($query) {
            return $query
                ->select('attribute_options.*')
                ->join('attributes', 'attribute_options.attribute_id', '=', 'attributes.id')
                ->where('attributes.code', 'unit_per_uom');
        })->get();

        $obj             = new OrderItem();
        $obj->id         = $order_item['id'];
        $obj->product_id = $order_item['product_id'];
        $obj->additional = $order_item['additional'];

        $product_additional_default = app(OrderItemRepository::class)->getAdditionalProduct($obj, 'en');
        $product_additional         = app(OrderItemRepository::class)->getAdditionalProduct($obj, $locale);

        if (isset($product_additional) && !empty($product_additional)) {
            $order_item['name'] = isset($product_additional['name']) ? $product_additional['name'] : $order_item->name;

            if (isset($order_item['uom_type'])) {
                $order_item['uom_type'] = isset($product_additional['uom_type_label']) ? $product_additional['uom_type_label'] : $order_item['uom_type'];
            }

            if (isset($order_item['unit_per_uom'])) {
                $unit_per_uom_label         = isset($product_additional_default['unit_per_uom_label']) ? $product_additional_default['unit_per_uom_label'] : $order_item['unit_per_uom'];
                $order_item['unit_per_uom'] = core()->formatUnitPerUom($unit_per_uom_label, $attribute_options_unit_per_uom);
            }
        }

        return $order_item;
    }

    /**
     * Format invoice, refund product by locale
     *
     * @param object $item
     * @return object
     */
    public function formatInvoiceRefundByLocale($item, $locale)
    {
        $obj             = new OrderItem();
        $obj->id         = $item->order_item_id;
        $obj->product_id = $item->product_id;
        $obj->additional = $item->additional;

        $product_additional = app(OrderItemRepository::class)->getAdditionalProduct($obj, $locale);

        if (isset($product_additional) && !empty($product_additional)) {
            $item->name = isset($product_additional['name']) ? $product_additional['name'] : $item->name;

            if (isset($item->uom_type)) {
                $item->uom_type = isset($product_additional['uom_type_label']) ? $product_additional['uom_type_label'] : $item->uom_type;
            }

            if (isset($item->unit_per_uom)) {
                $item->unit_per_uom = isset($product_additional['unit_per_uom_label']) ? $product_additional['unit_per_uom_label'] : $item->unit_per_uom;
            }
        }

        return $item;
    }

    /**
     * Convert kg to milligram, gram, kg, ton
     *
     * @param number $kg
     * @return string
     */
    public function outputWeight($kg)
    {
        $power = floor(log($kg, 10));

        if ($power >= 3) {
            $unit  = 'Ton';
            $power = 3;
        } elseif ($power >= 0 && $power <= 2) {
            $unit  = 'Kg';
            $power = 0;
        } elseif ($power >= -3 && $power <= -1) {
            $unit  = 'Gram';
            $power = -3;
        } else {
            $unit  = 'MiliGram';
            $power = -6;
        }

        return ($kg / pow(10, $power)) . ' ' . $unit;
    }

    /**
     * Convert value gram, kg, ton to kg
     *
     * @param number $value
     * @param string $type
     * @return number
     */
    public function convertValueToKg($value, $type)
    {
        switch (strtolower($type)) {
            case 'gram':
                return $value / 1000;
                break;

            case 'kg':
                return $value;
                break;

            case 'ton':
                return $value * 1000;
                break;

            default:
                return $value;
                break;
        }

        return $value;

    }

    /**
     * Convert value ml to l
     *
     * @param number $value
     * @param string $type
     * @return number
     */
    public function convertValueToLitter($value, $type)
    {
        switch (strtolower($type)) {
            case 'ml':
                return $value / 1000;
                break;

            case 'l':
                return $value;
                break;

            default:
                return $value;
                break;
        }

        return $value;

    }

    /**
     * Convert value ML, L
     *
     * @param number $value
     * @param string $type
     * @return string
     */
    public function convertLitersMilliliters($value, $type)
    {
        switch (strtolower($type)) {
            case 'ml':
                return ($value >= 1000) ? (strval($value / 1000) . ' L') : (strval($value) . 'ML');
                break;

            case 'l':
                return $value < 0 ? strval($value * 1000) . ' ML' : strval($value) . ' L';
                break;

            default:
                return strval($value) . ' ' . strtoupper($type);
                break;
        }

        return strval($value) . ' ' . strtoupper($type);
    }

    /**
     * Convert value gram, kg, ton
     *
     * @param object $order_items
     * @return string
     */
    public function convertTotalParcelVolume($order_items)
    {
        $attribute_options_unit_per_uom = app(AttributeOptionRepository::class)->scopeQuery(function ($query) {
            return $query
                ->select('attribute_options.*')
                ->join('attributes', 'attribute_options.attribute_id', '=', 'attributes.id')
                ->where('attributes.code', 'unit_per_uom');
        })->get();

        $total_parcel_volume = 0;
        $volume_per_uom      = 0;
        $unit_per_uom        = '';
        $uom_type            = '';
        $value               = '';

        foreach ($order_items as $order_item) {

            if ($order_item->volume_per_uom <= 0) {
                $total_parcel_volume += $order_item->qty_offered;
                $unit_per_uom   = $order_item->unit_per_uom ? $order_item->unit_per_uom : $order_item->uom_type;
                $uom_type       = $order_item->uom_type;
                $volume_per_uom = $order_item->volume_per_uom;
            } else {
                $unit_per_uom_admin = $this->getAdminNameUnitPerUom($order_item->unit_per_uom, $attribute_options_unit_per_uom);

                if (in_array(strtolower($order_item->unit_per_uom), ['ml', 'l'])) {
                    $total_parcel_volume += core()->convertValueToLitter($order_item->qty_offered * $order_item->volume_per_uom, $unit_per_uom_admin);
                } else {
                    $total_parcel_volume += core()->convertValueToKg($order_item->qty_offered * $order_item->volume_per_uom, $unit_per_uom_admin);
                }

                $unit_per_uom   = $unit_per_uom_admin;
                $volume_per_uom = $order_item->volume_per_uom;
            }
        }

        if ($volume_per_uom <= 0) {
            // convert data when unit per uom is valid
            if ($unit_per_uom) {
                $unit_per_uom_admin = $this->getAdminNameUnitPerUom($unit_per_uom, $attribute_options_unit_per_uom);

                if (in_array(strtolower($unit_per_uom_admin), ['ml', 'l'])) {
                    $value_litter = core()->convertValueToLitter($total_parcel_volume, $unit_per_uom_admin);
                    $unit_per_uom = 'l';
                    $value        = core()->convertLitersMilliliters($value_litter, $unit_per_uom);
                    $data         = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
                } elseif (in_array(strtolower($unit_per_uom_admin), ['gram', 'kg', 'ton'])) {
                    $value_kg = core()->convertValueToKg($total_parcel_volume, $unit_per_uom_admin);
                    $value    = core()->outputWeight($value_kg);
                    $data     = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
                } else {
                    $data = $total_parcel_volume . ' ' . $uom_type;
                }
            } else {
                $data = $total_parcel_volume . ' ' . $uom_type;
            }
        } else {
            if (in_array(strtolower($unit_per_uom), ['ml', 'l'])) {
                $unit_per_uom = 'l';
                $value        = core()->convertLitersMilliliters($total_parcel_volume, $unit_per_uom);
            } else {
                $value = core()->outputWeight($total_parcel_volume);
            }

            $data = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
        }

        return $data;
    }

    /**
     * Convert value gram, kg, ton shipment
     *
     * @param object $order_items
     * @return string
     */
    public function convertTotalParcelVolumeShipment($shipment_items)
    {
        $attribute_options_unit_per_uom = app(AttributeOptionRepository::class)->scopeQuery(function ($query) {
            return $query
                ->select('attribute_options.*')
                ->join('attributes', 'attribute_options.attribute_id', '=', 'attributes.id')
                ->where('attributes.code', 'unit_per_uom');
        })->get();

        $total_parcel_volume = 0;
        $volume_per_uom      = 0;
        $unit_per_uom        = '';
        $uom_type            = '';
        $value               = '';

        foreach ($shipment_items as $shipment_item) {

            $order_item = $shipment_item->order_item;

            if ($order_item->volume_per_uom <= 0) {
                $total_parcel_volume += $shipment_item->qty;
                $unit_per_uom   = $order_item->unit_per_uom ? $order_item->unit_per_uom : $order_item->uom_type;
                $uom_type       = $order_item->uom_type;
                $volume_per_uom = $order_item->volume_per_uom;
            } else {
                $unit_per_uom_admin = $this->getAdminNameUnitPerUom($order_item->unit_per_uom, $attribute_options_unit_per_uom);

                if (in_array(strtolower($unit_per_uom_admin), ['ml', 'l'])) {
                    $total_parcel_volume += core()->convertValueToLitter($shipment_item->qty * $order_item->volume_per_uom, $unit_per_uom_admin);
                } else {
                    $total_parcel_volume += core()->convertValueToKg($shipment_item->qty * $order_item->volume_per_uom, $unit_per_uom_admin);
                }

                $unit_per_uom   = $unit_per_uom_admin;
                $volume_per_uom = $order_item->volume_per_uom;
            }
        }

        if ($volume_per_uom <= 0) {
            // convert data when unit per uom is valid
            if ($unit_per_uom) {
                $unit_per_uom_admin = $this->getAdminNameUnitPerUom($unit_per_uom, $attribute_options_unit_per_uom);

                if (in_array(strtolower($unit_per_uom_admin), ['ml', 'l'])) {
                    $value_litter = core()->convertValueToLitter($total_parcel_volume, $unit_per_uom_admin);
                    $unit_per_uom = 'l';
                    $value        = core()->convertLitersMilliliters($value_litter, $unit_per_uom);
                    $data         = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
                } elseif (in_array(strtolower($unit_per_uom_admin), ['gram', 'kg', 'ton'])) {
                    $value_kg = core()->convertValueToKg($total_parcel_volume, $unit_per_uom_admin);
                    $value    = core()->outputWeight($value_kg);
                    $data     = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
                } else {
                    $data = $total_parcel_volume . ' ' . $uom_type;
                }
            } else {
                $data = $total_parcel_volume . ' ' . $uom_type;
            }
        } else {
            if (in_array(strtolower($unit_per_uom), ['ml', 'l'])) {
                $unit_per_uom = 'l';
                $value        = core()->convertLitersMilliliters($total_parcel_volume, $unit_per_uom);
            } else {
                $value = core()->outputWeight($total_parcel_volume);
            }

            $data = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
        }

        return $data;
    }

    /**
     * Get total selected packages
     *
     * @param object $order_items
     * @return number
     */
    public function getTotalSelectedPackages($order_items)
    {
        $total_selected_packages = 0;
        foreach ($order_items as $order_item) {
            $total_selected_packages += $order_item->qty_offered;
        }

        return $total_selected_packages;
    }

    /**
     * Get total selected packages shipment
     *
     * @param object $shipment_items
     * @return number
     */
    public function getTotalSelectedPackagesShipment($shipment_items)
    {
        $total_selected_packages = 0;
        foreach ($shipment_items as $shipment_item) {
            $total_selected_packages += $shipment_item->qty;
        }

        return $total_selected_packages;
    }

    /**
     * Format Total Parcel Volume
     *
     * @param string $value
     * @param objects $attribute_options_unit_per_uom
     * @return string
     */
    public function formatTotalParcelVolume($value, $attribute_options_unit_per_uom)
    {
        $locale             = app()->getLocale();
        $data               = explode(' ', $value);
        $admin_unit_per_uom = end($data);

        foreach ($attribute_options_unit_per_uom as $item) {
            if (strtolower($item->admin_name) == strtolower($admin_unit_per_uom)) {
                foreach ($item->translations as $translation) {

                    if ($translation->locale == $locale) {
                        return $data[0] . ' ' . $translation->label;
                    }
                }
            }
        }

        return $value;
    }

    /**
     * Get Admin Name Unit Per Uom
     *
     * @param string $value
     * @param objects $attribute_options_unit_per_uom
     * @return string
     */
    public function getAdminNameUnitPerUom($value, $attribute_options_unit_per_uom)
    {
        $locale = app()->getLocale();

        foreach ($attribute_options_unit_per_uom as $item) {

            foreach ($item->translations as $translation) {
                if (strtolower($translation->label) == strtolower($value)) {
                    return $item->admin_name;
                }
            }

        }

        return $value;
    }

    /**
     * Format Unit Per Uom
     *
     * @param string $value
     * @param objects $attribute_options_unit_per_uom
     * @return string
     */
    public function formatUnitPerUom($value, $attribute_options_unit_per_uom)
    {
        $locale = app()->getLocale();

        foreach ($attribute_options_unit_per_uom as $item) {
            if (strtolower($item->admin_name) == strtolower($value)) {
                foreach ($item->translations as $translation) {

                    if ($translation->locale == $locale) {
                        return $translation->label;
                    }
                }
            }
        }

        return $value;
    }

    /**
     * Convert Product Total Parcel Volume Group
     *
     * @param array $groups
     * @param objects $items
     * @return string
     */
    public function convertProductTotalParcelVolumeGroup($groups, $items)
    {
        $attribute_options_unit_per_uom = app(AttributeOptionRepository::class)->scopeQuery(function ($query) {
            return $query
                ->select('attribute_options.*')
                ->join('attributes', 'attribute_options.attribute_id', '=', 'attributes.id')
                ->where('attributes.code', 'unit_per_uom');
        })->get();

        foreach ($groups as $key => $cate) {
            $total_parcel_volume = 0;
            $unit_per_uom        = '';

            foreach ($cate as $cate_item) {
                $unit_per_uom   = '';
                $volume_per_uom = 0;
                $product        = $cate_item->product;
                $productFlat    = $cate_item->product->product_flats()->where('locale', 'en')->first();

                if (!$productFlat->unit_per_uom_label || !$product->volume_per_uom) {
                    $total_parcel_volume += $cate_item->quantity;
                    $unit_per_uom   = isset($productFlat->uom_type_label) ? $productFlat->uom_type_label : $product->uom_type;
                    $volume_per_uom = $product->volume_per_uom;

                } else {
                    $unit_per_uom_admin = $this->getAdminNameUnitPerUom($productFlat->unit_per_uom_label, $attribute_options_unit_per_uom);

                    if (in_array(strtolower($productFlat->unit_per_uom_label), ['ml', 'l'])) {
                        $total_parcel_volume += core()->convertValueToLitter($cate_item->quantity * $product->volume_per_uom, $unit_per_uom_admin);
                    } else {
                        $total_parcel_volume += core()->convertValueToKg($cate_item->quantity * $product->volume_per_uom, $unit_per_uom_admin);
                    }

                    $unit_per_uom   = $unit_per_uom_admin;
                    $volume_per_uom = $product->volume_per_uom;
                }
            }

            if ($volume_per_uom <= 0 || !$volume_per_uom) {

                if ($unit_per_uom) {
                    $unit_per_uom_admin = $this->getAdminNameUnitPerUom($unit_per_uom, $attribute_options_unit_per_uom);

                    if (in_array(strtolower($unit_per_uom_admin), ['ml', 'l'])) {
                        $value_litter = core()->convertValueToLitter($total_parcel_volume, $unit_per_uom_admin);
                        $unit_per_uom = 'l';
                        $value        = core()->convertLitersMilliliters($value_litter, $unit_per_uom);
                        $data         = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
                    } elseif (in_array(strtolower($unit_per_uom_admin), ['gram', 'kg', 'ton'])) {
                        $value_kg = core()->convertValueToKg($total_parcel_volume, $unit_per_uom_admin);
                        $value    = core()->outputWeight($value_kg);
                        $data     = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
                    } else {
                        $data = $total_parcel_volume . ' ' . $unit_per_uom;
                    }
                } else {
                    $data = $total_parcel_volume . ' ' . $unit_per_uom;
                }
            } else {
                if (in_array(strtolower($unit_per_uom), ['ml', 'l'])) {
                    $unit_per_uom = 'l';
                    $value        = core()->convertLitersMilliliters($total_parcel_volume, $unit_per_uom);
                } else {
                    $value = core()->outputWeight($total_parcel_volume);
                }

                $data = $this->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
            }

            // update cart items
            foreach ($items as &$item) {
                $categories  = $item->product->categories;
                $inventories = $item->product->inventories;

                if (isset($inventories[0]->inventory_source_id)) {
                    $key_item = $categories[0]->id . '_' . $inventories[0]->inventory_source_id;
                } else {
                    $key_item = $categories[0]->id . '_' . 0;
                }

                if ($key == $key_item) {
                    $item->total_parcel_volume = $data;
                }
            }

        }

        return $items;

    }

    /**
     * Group Product Cart By Category
     *
     * @param objects $items
     * @return array
     */
    public function groupProductCartByCategory($items)
    {
        $group = [];
        foreach ($items as $item) {
            $categories  = $item->product->categories;
            $inventories = $item->product->inventories;

            if (isset($inventories[0]->inventory_source_id)) {
                $key = $categories[0]->id . '_' . $inventories[0]->inventory_source_id;
            } else {
                $key = $categories[0]->id . '_' . 0;
            }

            $group[$key][] = $item;
        }

        return $group;
    }

    /**
     * Get Path Product From Order Items
     *
     * @param objects $order_items
     * @return objects
     */
    public function getPathProduct($order_items)
    {
        foreach ($order_items as &$order_item) {
            $slug_cate    = '';
            $slug_product = '';

            $category = app(CategoryRepository::class)->where('attribute_family_id', $order_item->attribute_family_id)->first();
            if ($category) {
                $category_translation = app(CategoryTranslationsRepository::class)->where(['category_id' => $category->id, 'locale' => 'en'])->first();
                if (!$category_translation) {
                    $category_translation = app(CategoryTranslationsRepository::class)->where(['category_id' => $category->id])->first();
                }

                if ($category_translation) {
                    $slug_cate = $category_translation->slug;
                }
            }

            $product_flat = app(ProductFlatRepository::class)->where(['product_id' => $order_item->product_id, 'locale' => 'en', 'status' => 1])->first();

            if (!$product_flat) {
                $product_flat = app(ProductFlatRepository::class)->where(['product_id' => $order_item->product_id, 'status' => 1])->first();
            }

            if ($product_flat) {
                $slug_product = $product_flat->url_key;
            }

            if ($slug_cate && $slug_product) {
                $order_item->path_product = '/catalog/' . $slug_cate . '/' . $slug_product;
            } else {
                $order_item->path_product = '';
            }
        }

        return $order_items;
    }

    /**
     * Get Path Product From Shipment Items
     *
     * @param objects $shipment_items
     * @return objects
     */
    public function getPathProductShipment($shipment_items)
    {
        foreach ($shipment_items as &$shipment_item) {
            $slug_cate    = '';
            $slug_product = '';

            $category = app(CategoryRepository::class)->where('attribute_family_id', $shipment_item->order_item->attribute_family_id)->first();
            if ($category) {
                $category_translation = app(CategoryTranslationsRepository::class)->where(['category_id' => $category->id, 'locale' => 'en'])->first();
                if (!$category_translation) {
                    $category_translation = app(CategoryTranslationsRepository::class)->where(['category_id' => $category->id])->first();
                }

                if ($category_translation) {
                    $slug_cate = $category_translation->slug;
                }
            }

            $product_flat = app(ProductFlatRepository::class)->where(['product_id' => $shipment_item->order_item->product_id, 'locale' => 'en', 'status' => 1])->first();

            if (!$product_flat) {
                $product_flat = app(ProductFlatRepository::class)->where(['product_id' => $shipment_item->order_item->product_id, 'status' => 1])->first();
            }

            if ($product_flat) {
                $slug_product = $product_flat->url_key;
            }

            if ($slug_cate && $slug_product) {
                $shipment_item->path_product = '/catalog/' . $slug_cate . '/' . $slug_product;
            } else {
                $shipment_item->path_product = '';
            }
        }

        return $shipment_items;
    }

    /**
     * Convert total parcel volume agent
     *
     * @param object $shipment_items
     * @return string
     */
    public function convertTotalParcelVolumeAgent($shipment_items)
    {
        if ($shipment_items->volume_per_uom > 0) {
            $attribute_options_unit_per_uom = app(AttributeOptionRepository::class)->scopeQuery(function ($query) {
                return $query
                    ->select('attribute_options.*')
                    ->join('attributes', 'attribute_options.attribute_id', '=', 'attributes.id')
                    ->where('attributes.code', 'unit_per_uom');
            })->get();
            $unit_per_uom_admin = core()->getAdminNameUnitPerUom($shipment_items->unit_per_uom, $attribute_options_unit_per_uom);
            $kg                 = core()->convertValueToKg($shipment_items->volume_per_uom * $shipment_items->qty_shipped, $unit_per_uom_admin);
            $value              = core()->outputWeight($kg);
            $parcel_volume      = core()->formatTotalParcelVolume($value, $attribute_options_unit_per_uom);
        } else {
            $productFlat   = app(ProductFlatRepository::class)->where('product_id', $shipment_items->product_id)->where('locale', 'en')->first();
            $unit_per_uom  = isset($shipment_items->uom_type) ? $shipment_items->uom_type : $productFlat->unit_per_uom_label;
            $parcel_volume = $shipment_items->qty_shipped . ' ' . $unit_per_uom;
        }
        return $parcel_volume;
    }

    /**
     * Total cancel price
     *
     * @param object $items
     * @return number
     */
    public function totalCancelPrice($items)
    {
        $total_cancel_price = 0;
        foreach ($items as $item) {
            $total_cancel_price += $item->qty_canceled * $item->trustineo_price;
        }

        return $total_cancel_price;
    }
}
