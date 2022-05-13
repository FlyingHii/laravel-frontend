@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.dashboard.title') }}
@stop

@section('content-wrapper')

    <div class="content full-page dashboard">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.dashboard.title') }}</h1>
            </div>

            <div class="page-action">
                <attributes-filter></attributes-filter>
            </div>
        </div>

        <div class="page-content">


            @foreach($statistics as $key => $statistic)
                @php
                    $viewConfig = $statistic['view_config'] ?? null;
                    if (empty($viewConfig)) {
                        continue;
                    }
                @endphp
                @if(!empty($viewConfig['element_type']) && $viewConfig['element_type'] == 'total')
                    @if(in_array($key, ['total_customers', 'total_orders', 'total_sale_final']))
                        <div class="dashboard-stats" style="padding: 15px">
                            @endif
                            <div class="dashboard-card">
                                <div class="title">
                                    {{ __('admin::app.dashboard.' . str_replace('_', '-', $key)) }}
                                </div>

                                <div class="data">
                                    @if(!empty($viewConfig['data_type']) && $viewConfig['data_type'] == 'price')
                                        {{ core()->formatBasePrice($statistic['current']) }}
                                    @elseif(!isset($statistic['total']))
                                        {{$statistic['current'] }}
                                    @else
                                        {{ $statistic['current']}}/{{$statistic['total']}}

                                    @endif

                                </div>
                            </div>
                            @if(in_array($key, ['total_agents', 'total_orders_completed', 'profit']))
                        </div>
                    @endif
                @endif
            @endforeach


            <div class="graph-stats">
                <div class="card" style="overflow: hidden;">
                    <div class="card-title" style="margin-bottom: 30px;">
                        {{ __('admin::app.dashboard.sales') }}
                    </div>

                    <div class="card-info" style="height: 100%;">

                        <canvas id="myChart" style="width: 100%; height: 87%"></canvas>

                    </div>
                </div>
            </div>

            @inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')


            <div class="sale-stock">
                @foreach($statistics as $key => $statistic)
                    @if(!empty($statistics['merchants_with_most_sales']) && $key == 'merchants_with_most_sales' && false)
                        <div class="card">
                            <div class="card-title">
                                {{ __('admin::app.dashboard.merchants-with-most-sales') }}
                            </div>

                            <div class="card-info {{ !count($statistics['merchants_with_most_sales']) ? 'center' : '' }}">
                                <ul>

                                    @foreach ($statistics['merchants_with_most_sales'] as $item)

                                        <li>
                                            @if ($item->seller_id)
                                                <a href="{{ route('admin.merchant.edit', ['id' => $item->seller_id]) }}">
                                                    @endif

                                                    <div class="image">
                                                        <span class="icon profile-pic-icon"></span>
                                                    </div>

                                                    <div class="description do-not-cross-arrow">
                                                        <div class="name ellipsis">
                                                            {{ $item->seller_name }}
                                                        </div>

                                                        <div class="info">
                                                            {{ __('admin::app.dashboard.order-count', ['count' => $item->total_orders]) }}
                                                            &nbsp;.&nbsp;
                                                            {{ __('admin::app.dashboard.revenue', [
                                                                'total' => core()->formatBasePrice($item->total_base_grand_total)
                                                            ])
                                                            }}
                                                        </div>
                                                    </div>

                                                    <span class="icon angle-right-icon"></span>

                                                    @if ($item->seller_id)
                                                </a>
                                            @endif
                                        </li>

                                    @endforeach

                                </ul>

                                @if (! count($statistics['merchants_with_most_sales']))

                                    <div class="no-result-found">

                                        <i class="icon no-result-icon"></i>
                                        <p>{{ __('admin::app.common.no-result-found') }}</p>

                                    </div>

                                @endif
                            </div>

                        </div>
                    @endif

                    @if(!empty($statistics['top_selling_categories']) && $key == 'top_selling_categories')
                        <div class="card">
                            <div class="card-title">
                                {{ __('admin::app.dashboard.top-performing-categories') }}
                            </div>

                            <div class="card-info {{ !count($statistic['current']) ? 'center' : '' }}">
                                @if(!empty($statistic['view_config']['view_all_route']) && !empty($statistic['current']))
                                    <div class="view-all">
                                        <a href="{{route('admin.dashboard.category.index')}}" >View all</a>
                                    </div>
                                @endif
                                <ul>

                                    @foreach ($statistic['current'] as $item)

                                        <li>
                                            <a href="{{!empty($item->attribute_family_id) ? route('admin.dashboard.category.detail.index', $item->attribute_family_id)  : '#' }}">
                                                <div class="description">
                                                    <div class="name">
                                                        {{ $item->attribute_family_name }}
                                                    </div>

                                                    <div class="info">
                                                        {{ __('admin::app.dashboard.product-count', ['count' => $item->total_products]) }}
                                                        &nbsp;.&nbsp;
                                                        {{ __('admin::app.dashboard.order-count', ['count' => $item->total_orders]) }}
                                                        &nbsp;.
                                                        {{ __('admin::app.dashboard.revenue', ['total' => core()->formatBasePrice($item->base_total_revenue)]) }}
                                                    </div>
                                                </div>

                                                <span class="icon angle-right-icon"></span>
                                            </a>
                                        </li>

                                    @endforeach

                                </ul>

                                @if (! count($statistic['current']))

                                    <div class="no-result-found">

                                        <i class="icon no-result-icon"></i>
                                        <p>{{ __('admin::app.common.no-result-found') }}</p>

                                    </div>

                                @endif
                            </div>
                        </div>
                        @continue
                    @endif

                    @if(empty($statistic['view_config']['element_type']) || $statistic['view_config']['element_type'] !== 'most_sale')
                        <?php continue; ?>
                    @endif



                    <div class="card">
                        <div class="card-title">
                            @if($key == 'top_selling_categories')
                                {{ __('admin::app.dashboard.top-performing-categories') }}
                            @else
                                {{ __('admin::app.dashboard.' . str_replace('_', '-', $key)) }}
                            @endif
                        </div>
                        @php

                            $key_statistic = $key;
                        @endphp
                        <div class="card-info {{ count($statistic['current']) <= 0 ? 'center' : '' }}">
                            @if(count($statistic['current']) > 0)
                                <div class="view-all">
                                    <a href="{{route($statistic['view_config']['view_all_route'])}}" >View all</a>
                                </div>
                            @endif

                            @if($statistic['current'])
                                <ul>
                                    @php
                                        $routeConfig = null;
                                        if(!empty($statistic['view_config']['route'])) {
                                            $routeConfig = $statistic['view_config']['route'];
                                        }
                                    @endphp
                                    @foreach ($statistic['current'] as $item)
                                        <li>
                                            @if (!empty($item->object_id) && !empty($routeConfig['name']) && !empty($routeConfig['params']))
                                                @php
                                                    $params = [];
                                                    foreach ($routeConfig['params'] as $key => $param) {
                                                        $params[$key] = $item->$param;
                                                    }
                                                @endphp
                                                <a href="{{ route($routeConfig['name'], $params) }}" >
                                                    @endif
                                                    <div class="description do-not-cross-arrow">
                                                        @if($key == 'top_selling_categories')
                                                            <div class="name">
                                                                {{ $item->category_name }}
                                                            </div>
                                                            <div class="info">
                                                                {{ __('admin::app.dashboard.product-count', ['count' => $item->total_products]) }}
                                                                &nbsp;.&nbsp;
                                                                {{ __('admin::app.dashboard.order-count', ['count' => $item->total_orders]) }}
                                                                &nbsp;.
                                                                {{ __('admin::app.dashboard.revenue', ['total' => core()->formatBasePrice($item->base_total_revenue)]) }}
                                                            </div>
                                                        @else
                                                            <div class="name ellipsis">
                                                                {{ $item->object_name }}

                                                            </div>


                                                            @if($key_statistic == 'agent_with_most_sales')
                                                                <div class="info">
                                                                    {{ __('admin::app.dashboard.shipment-count', ['count' => $item->total_orders]) }}
                                                                    &nbsp;.&nbsp;
                                                                    {{ __('admin::app.dashboard.revenue', [
                                                                        'total' => core()->formatBasePrice($item->base_total_revenue)
                                                                    ])
                                                                    }}
                                                                </div>
                                                            @else
                                                                <div class="info">
                                                                    {{ __('admin::app.dashboard.order-count', ['count' => $item->total_orders]) }}
                                                                    &nbsp;.&nbsp;
                                                                    {{ __('admin::app.dashboard.revenue', [
                                                                        'total' => core()->formatBasePrice($item->base_total_revenue)
                                                                    ])
                                                                    }}
                                                                </div>
                                                            @endif

                                                        @endif
                                                    </div>

                                                    <span class="icon angle-right-icon"></span>

                                                    @if (!empty($item->object_id) && !empty($routeConfig['name']) && !empty($routeConfig['params']))
                                                </a>
                                            @endif
                                        </li>

                                    @endforeach

                                </ul>
                            @endif

                            @if (count($statistic['current']) <= 0)
                                <div class="no-result-found">

                                    <i class="icon no-result-icon"></i>
                                    <p>{{ __('admin::app.common.no-result-found') }}</p>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach

                @isset($statistics['stock_threshold'])
                    <div class="card">
                        <div class="card-title">
                            {{ __('admin::app.dashboard.stock-threshold') }}
                        </div>

                        <div class="card-info {{ !count($statistics['stock_threshold']) ? 'center' : '' }}">
                            <ul>

                                @foreach ($statistics['stock_threshold'] as $item)

                                    <li>
                                        <a href="{{ route('admin.catalog.products.edit', $item->product_id) }}">
                                            <div class="image">
                                                <?php $productBaseImage = $productImageHelper->getProductBaseImage($item->product); ?>

                                                <img class="item-image" src="{{ $productBaseImage['small_image_url'] }}" />
                                            </div>

                                            <div class="description do-not-cross-arrow">
                                                <div class="name ellipsis">
                                                    @if (isset($item->product->name))
                                                        {{ $item->product->name }}
                                                    @endif
                                                </div>

                                                <div class="info">
                                                    {{ __('admin::app.dashboard.qty-left', ['qty' => $item->total_qty]) }}
                                                </div>
                                            </div>

                                            <span class="icon angle-right-icon"></span>
                                        </a>
                                    </li>

                                @endforeach

                            </ul>

                            @if (! count($statistics['stock_threshold']))

                                <div class="no-result-found">

                                    <i class="icon no-result-icon"></i>
                                    <p>{{ __('admin::app.common.no-result-found') }}</p>

                                </div>

                            @endif
                        </div>

                    </div>
                @endisset
            </div>
        </div>
    </div>

@stop
