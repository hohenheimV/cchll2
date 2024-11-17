<?php

namespace App\Providers;

use Html;
use Form;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class MacroServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        self::html_macro();
        self::html_macro_date();
        self::html_macro_label();
        self::html_macro_notification();
        self::html_macro_lesen();
    }

    static public function html_macro()
    {
        Html::macro('expButton', function ($label, $attributes = []) {
            $name = Route::currentRouteName();
            $name = explode('.', $name);

            $name = $name[0] == 'user' ? route('user.login') : route('pengurusan.login');

            $button = '<button ' . app('html')->attributes($attributes) . ' ' . 'onclick="window.location=\'' . $name . '\'">';
            $button .= $label;
            $button .= '</button>';
            return $button;
        });

        Html::macro('active', function ($route, $class = 'active') {
            $name = Route::currentRouteName();
            if(is_array($route)){
                $key = array_filter($route, function($element) use($name) {
                    return Str::startsWith($name, $element) !== FALSE;
                });
                return $key ? $class : '';
            }
            return Str::startsWith($name, $route) ? $class : '';
        });

        Html::macro('images', function ($path, $attributes = []) {
            return '<img src="' . asset($path) . '"' . app('html')->attributes($attributes) . '/>';
        });

        /**
         * buttonSidebar nav-item
         */

        Html::macro('buttonSidebarNavLink', function ($name, $icon = null, $attributes = []) {


            $button = '<button ' . app('html')->attributes($attributes) . '>';
            $button .= '<i class="nav-icon ' . $icon . '"></i>';
            $button .= '<p>' . $name . '</p>';
            $button .= '</button>';
            return $button;
        });
        Html::macro('buttonSidebarNavLinkTreeview', function ($name, $icon = null, $attributes = []) {

            $button = '<button ' . app('html')->attributes($attributes) . '>';
            $button .= '<i class="nav-icon ' . $icon . '"></i>';
            $button .= '<p>' . $name . '<i class="fas fa-angle-left right"></i></p>';
            $button .= '</button>';
            return $button;
        });
        Html::macro('buttonSidebaNavItemTree', function ($name, $attributes = []) {

            $button = '<button ' . app('html')->attributes($attributes) . '>';
            $button .= '<i class="far fa-circle nav-icon"></i>';
            $button .= '<p>' . $name . '</p>';
            $button .= '</button>';
            return $button;
        });

        Html::macro('pagination', function ($results = null) {
            if ($results) {
                $perPage = ($results->total() < $results->perPage() ? $results->total() : $results->perPage());
                return "<div class='text-muted mx-2'><small>Laman {$results->currentPage()} daripada {$results->lastPage()}, menunjukkan {$perPage} data daripada {$results->total()} jumlah data, bermula pada baris {$results->firstItem()}, berakhir pada baris {$results->lastItem()}</small></div><div class='mx-2'><div>" . $results->links() . "</div></div>";
            }
        });

        Html::macro('pagination_simple', function ($results = null) {
            if ($results)
                return $results->links();
        });
    }
    static public function html_macro_date()
    {
        /**
         *
         */
        Html::macro('date', function ($value, $format = 'd-m-Y') {
            return Carbon::parse($value)->format($format);
        });

        /**
         *
         */
        Html::macro('time', function ($value, $format = 'H:i A') {
            return Carbon::parse($value)->locale('ms')->format($format);
        });

        /**
         *
         */
        Html::macro('datetime', function ($value, $format = 'd-m-Y h:i A') {
            return Carbon::parse($value)->locale('ms')->format($format);
        });

        /**
         *
         */
        Html::macro('isSameDay', function ($start, $end, $format) {

            if (!Carbon::parse($start)->isSameDay($end)) {
                return Carbon::parse($start)->locale('ms')->format($format) . " hingga " . Carbon::parse($end)->locale('ms')->format($format);
            }
            return Carbon::parse($start)->locale('ms')->format($format);
        });

        /**
         *
         */
        Html::macro('tooltip', function ($title = 'Tooltip on top', $placement = 'top', $toggle = 'tooltip') {
            return app('html')->attributes(['data-tooltip' => $toggle, 'data-placement' => $placement, 'title' => $title]);
        });

        /**
         *
         */
        Html::macro('badgeIcon', function ($value) {
            $badgeSuccess = "<span class='badge badge-success p-1'><i class='fas fa-check'></i></span>";
            $badgeDanger = "<span class='badge badge-danger p-1'><i class='fas fa-times'></i></span>";
            return ($value ? $badgeSuccess : $badgeDanger);
        });

        /**
         *
         */
        Html::macro('badgeText', function ($value) {
            $textSuccess = "<i class='fas fa-check-circle text-success'></i>";
            $textDanger = "<i class='fas fa-times-circle text-danger'></i>";
            return ($value ? $textSuccess : $textDanger);
        });

        Html::macro('badgeColor', function ($value, $color) {
            return "<span class='badge badge-{$color} status'>$value</span>";
        });
    }
    static public function html_macro_label()
    {

        Html::macro('hasError', function ($errors, $field) {
            if ($errors->has("{$field}")) {
                foreach ($errors->get($field) as $message) {
                    return "<span class='invalid-feedback' role='alert'><strong>$message</strong></span>";
                }
            }
        });

        Html::macro('isInvalid', function ($errors, $field) { {
                if ($errors->has("{$field}")) {
                    return $errors->has("{$field}") ? 'is-invalid' : '';
                }
            }
        });

        Html::macro('pagination', function ($results = null) {

            if ($results) {
                $perPage = ($results->total() < $results->perPage() ? $results->total() : $results->perPage());
                return "<div class='text-muted mx-2'><small>Laman {$results->currentPage()} daripada {$results->lastPage()}, menunjukkan {$perPage} data daripada {$results->total()} jumlah data, bermula pada baris {$results->firstItem()}, berakhir pada baris {$results->lastItem()}</small></div><div class='mx-2'><div>" . $results->links() . "</div></div>";
            }
        });

        Html::macro('pagination_simple', function ($results = null) {

            if ($results)
                return $results->links();
        });
    }
    static public function html_macro_notification()
    {
        Html::macro('notification_alert', function ($type, $message, $class = null) {

            return "<div class='alert alert-{$type} alert-dismissible callout callout-{$type} callout-styled-left alert-bordered m-0 $class'><button type='button' class='close' data-dismiss='alert'><span>&times;</span><span class='sr-only'>Padam</span></button><strong>{$message}</strong></div>";
        });

        Html::macro('forelse_alert', function ($keyword, $data, $style = 'danger', $class = null) {
            if ($keyword) {
                return "<div class='alert alert-$style'><i class='icon fas fa-ban $class'></i> Carian kekunci <mark>$keyword</mark> tidak dijumpai.</div>";
            }
            return "<div class='alert alert-$style $class'><i class='icon fas fa-ban'></i> Tiada maklumat $data</div>";
        });

        Html::macro('info_alert', function ($text, $style = 'info', $class = null) {
            return "<div class='alert alert-$style $class'>$text</div>";
        });
    }

    static public function html_macro_lesen()
    {

        Html::macro('badgeText', function ($value) {
            return ($value ? "<i class='fas fa-check-circle text-success'></i>" : "<i class='fas fa-times-circle text-danger'></i>");
        });

        Html::macro('badgeText', function ($value, $textTrue, $textFalse, $date = null) {
            if ($value && $date) {
                $dateExp = Carbon::create($date->year, $date->month, $date->day)->getTimestamp(); //Convert Tarikh Exp dgn Carbon format
                $dateToday = Carbon::now()->getTimestamp();

                return ($dateExp > $dateToday ? "<span class='badge badge-success'>$textTrue</span>" : "<span class='badge badge-danger'>Luput</span>");
            }
            return ($value ? "<span class='badge badge-success'>$textTrue</span>" : "<span class='badge badge-danger'>$textFalse</span>");
        });

        Html::macro('badgeExpired', function ($endDate, $exp = '-6 months') {

            $today = Carbon::today(); //Dapatkan Full date hari ni
            $dateExp = Carbon::create($endDate->year, $endDate->month, $endDate->day); //Convert Tarikh Exp dgn Carbon format
            $dateReminder = Carbon::create($endDate->year, $endDate->month, $endDate->day)->modify($exp); //Tarikh Exp 6 bulan sebelum
            $difference = Carbon::today()->diff($dateExp); //Cari beza today dan Tarikh Exp ( tahun, bulan, hari )
            $diff_days = $dateExp->getTimestamp() - $today->getTimestamp(); //Cari beza time()

            $badge = ($today->getTimestamp() > $dateReminder->getTimestamp() ? "badge-warning" : "badge-dark");
            $blink = ($today->getTimestamp() > $dateReminder->getTimestamp() ? "blinking" : "");

            //$out = self::format_interval($difference);

            $result = '';
            if ($difference->y) {
                $result .= "$difference->y tahun ";
            }
            if ($difference->m) {
                $result .= "$difference->m bulan ";
            }
            if ($difference->d) {
                $result .= "$difference->d hari ";
            }

            $out = $result . 'lagi';


            if ($diff_days > 0) {
                return " <span class='badge $badge'><span class='$blink'><i class='fas fa-clock'></i> $out</span></span>";
            }
        });
    }
}
