<div class="navbar-top">
    <div class="navbar-top-left">
        <div class="brand-logo">
            <a href="{{ route('admin.dashboard.index') }}">
                @if (core()->getConfigData('general.design.admin_logo.logo_image'))
                <img src="{{ \Illuminate\Support\Facades\Storage::url(core()->getConfigData('general.design.admin_logo.logo_image')) }}"
                    alt="{{ config('app.name') }}" style="height: 40px; width: 110px;" />
                @else
                <img src="{{ asset('vendor/webkul/ui/assets/images/logo.png') }}" alt="{{ config('app.name') }}" />
                @endif
            </a>
        </div>
    </div>

    <div class="navbar-top-right">
        <div class="profile">
            <span class="avatar">
            </span>

            <div class="profile-info">
                <notification></notification>
            </div>

            <div class="profile-info">
                <div class="dropdown-toggle">
                    <div style="display: inline-block; vertical-align: middle;">
                        <span class="name">
                            {{ auth()->guard('admin')->user()->name }}
                        </span>

                        <span class="role">
                            {{ auth()->guard('admin')->user()->role['name'] }}
                        </span>
                    </div>
                    <i class="icon arrow-down-icon active"></i>
                </div>

                <div class="dropdown-list bottom-right">
                    <span
                        class="app-version">{{ __('admin::app.layouts.app-version', ['version' => 'v' . config('app.version')]) }}</span>

                    <div class="dropdown-container">
                        <label>Account</label>
                        <ul>
                            <li>
                                <a href="{{ env('APP_URL') }}"
                                    target="_blank">{{ __('admin::app.layouts.visit-shop') }}</a>
                            </li>
                            <li>
                                <a
                                    href="{{ route('admin.account.edit') }}">{{ __('admin::app.layouts.my-account') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.session.destroy') }}">{{ __('admin::app.layouts.logout') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @parent

    <script type="text/x-template" id="notification-template">
       <a id="bell-icon" :href="`${baseUrl}/notifications`">
           <span><label v-if="count">@{{ count }}</label><v-icon name="bell" scale="2" /></span>
        </a>
    </script>

    <script>

        Vue.component('notification', {

            template: '#notification-template',

            inject: ['$validator'],

            data: function() {
                return {
                    count: 0,
                    user: @json(auth('admin')->user()),
                    baseUrl: "{{ url()->to('/'.config('app.admin_url')) }}"
                }
            },

            created() {
                this.getNotifications();
            },

            mounted() {
                window.Echo.private(`admin.order.${this.user.id}`)
                    .notification((notification) => {
                        this.getNotifications();

                        if (notification.message.title && notification.message.content) {
                            this.$toastr.Add({
                                name: "OrderNotification", // this is give you ability to use removeByName method
                                title: notification.message.title, // Toast Title
                                msg: notification.message.content, // Toast Message
                                clickClose: true, // Click Close Disable
                                timeout: 5000, // Remember defaultTimeout is 5 sec.(5000) in this case the toast won't close automatically
                                //progressBarValue: 50, // Manually update progress bar value later; null (not 0) is default
                                position: "toast-top-center", // Toast Position.
                                type: "success", // Toast type,
                                preventDuplicates: true, //Default is false,
                                style: { backgroundColor: "blue" } // bind inline style to toast  (check [Vue doc](https://vuejs.org/v2/guide/class-and-style.html#Binding-Inline-Styles) for more examples)
                            });
                        }
                    });

                window.Echo.private(`admin.user.${this.user.id}`)
                    .notification((notification) => {
                        this.getNotifications();

                        if (notification.message.title && notification.message.content) {
                            this.$toastr.Add({
                                name: "AdminNotification", // this is give you ability to use removeByName method
                                title: notification.message.title, // Toast Title
                                msg: notification.message.content, // Toast Message
                                clickClose: true, // Click Close Disable
                                timeout: 5000, // Remember defaultTimeout is 5 sec.(5000) in this case the toast won't close automatically
                                //progressBarValue: 50, // Manually update progress bar value later; null (not 0) is default
                                position: "toast-top-center", // Toast Position.
                                type: "success", // Toast type,
                                preventDuplicates: true, //Default is false,
                                style: { backgroundColor: "blue" } // bind inline style to toast  (check [Vue doc](https://vuejs.org/v2/guide/class-and-style.html#Binding-Inline-Styles) for more examples)
                            });
                        }
                    });

                window.Echo.private(`admin.notification.${this.user.id}`)
                    .listen('.notification.updated', (e) => {
                        this.count = e.unread || 0;
                    });
            },

            methods: {
                getNotifications : async function() {
                    try {
                        const response = await window.axios.get(`${this.baseUrl}/notifications/api/me/count`);
                        this.count = response.data.data.unread;
                    } catch (error) {
                        console.error(error);
                    }
                }
            }
        });
    </script>

@endpush
