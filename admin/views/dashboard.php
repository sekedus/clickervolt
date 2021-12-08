<div class='wrap clickervolt-section-dashboard'>

    <!-- This invisible h1 tag is only here to define where to display alert/badge messages -->
    <h1 style="display: none;">ClickerVolt</h1>

    <div id="clickervolt-logo"></div>

    <div id="options-accordion">
        <h3 class="button">Create/Edit Link</h3>
        <div style="display: none;">
            <p>
                <?php
                ClickerVolt\ViewLoader::newLink();
                ?>
            </p>
        </div>
    </div>
    <a href="https://help.clickervolt.com/" target="_blank" class="button">Docs & Tutorials</a>

    <div id="tabs-for-stats" class="tabs-wrapper">

        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-links"><i class="material-icons links"></i>Links</li>
            <li class="tab-link" data-tab="tab-reports"><i class="material-icons reports"></i>Reports</li>
            <li class="tab-link" data-tab="tab-clicklog"><i class="material-icons live-clicks"></i>Live Clicks</li>
            <li class="tab-link right" data-tab="tab-settings"><i class="material-icons settings"></i>Settings</li>
            <!--<li class="tab-link right" data-tab="tab-news"><i class="material-icons latest-news"></i>Latest News</li>-->
        </ul>

        <?php include __DIR__ . '/dashboardTabLinks.php'; ?>
        <?php include __DIR__ . '/dashboardTabReports.php'; ?>
        <?php include __DIR__ . '/dashboardTabClickLog.php'; ?>
        <?php /*include __DIR__ . '/dashboardTabLatestNews.php';*/ ?>
        <?php include __DIR__ . '/dashboardTabSettings.php'; ?>

    </div>

</div>


<script>
    jQuery(document).ready(function() {

        ClickerVoltFunctions.extendJQueryValidator();

        ClickerVoltFunctions.initAccordionButton('#options-accordion', ClickerVoltStatsFunctions.updateFixedHeader, ClickerVoltStatsFunctions.updateFixedHeader);
        ClickerVoltFunctions.initTabs('#tabs-for-stats', function(selectedTabId) {
            ClickerVoltStatsFunctions.updateFixedHeader();
            jQuery('#tabs-for-stats').trigger('tab-change', [{
                selectedTabId: selectedTabId
            }]);
        });

        var statsTables = [];
        statsTables.push(initLinksTable());
        statsTables.push(initReportsTable());

        ClickerVoltLinkController.onLinkSaved(function() {
            for (var i = 0; i < statsTables.length; i++) {
                statsTables[i].ajax.reload(ClickerVoltStatsFunctions.updateFixedHeader);
            }
            initSlugFilter();
        });

        ClickerVoltLinkController.onSourceSaved(function() {
            initSourceSelect(jQuery('#source-filter'), 'segment-filter');
        });

        jQuery('select.heatmap').each(function() {
            var $select = jQuery(this);

            ClickerVoltFunctions.addOptionToSelect($select, ClickerVoltStatsFunctions.COLUMN_PROFIT, 'Heatmap: Profit');
            ClickerVoltFunctions.addOptionToSelect($select, ClickerVoltStatsFunctions.COLUMN_ACTIONS, 'Heatmap: Actions #');
            ClickerVoltFunctions.addOptionToSelect($select, ClickerVoltStatsFunctions.COLUMN_ATTENTION_RATE, 'Heatmap: Attention Rate');
            ClickerVoltFunctions.addOptionToSelect($select, ClickerVoltStatsFunctions.COLUMN_INTEREST_RATE, 'Heatmap: Interest Rate');
            ClickerVoltFunctions.addOptionToSelect($select, ClickerVoltStatsFunctions.COLUMN_DESIRE_RATE, 'Heatmap: Desire Rate');
            ClickerVoltFunctions.addOptionToSelect($select, 'none', 'Heatmap: None');

            ClickerVoltFunctions.initSelect2($select);

            $select.on('change', function() {
                var forTable = jQuery(this).attr('for');
                var columnTitle = jQuery(this).find('option:selected').val();

                if (columnTitle == 'none') {
                    ClickerVoltStatsFunctions.enableHeatmap(jQuery(forTable), columnTitle, false);
                } else {
                    ClickerVoltStatsFunctions.enableHeatmap(jQuery(forTable), columnTitle, true);
                }
            });

            $select.trigger('change');
        });

        jQuery(window).on('resize clickervolt-resized', function() {
            monitorStickyAdminBar();
        });

        jQuery(window).trigger('clickervolt-resized');
    });

    /**
     * 
     */
    function monitorStickyAdminBar() {
        var cvAdminBarPosition = jQuery('#wpadminbar').css('position');
        if (cvAdminBarPosition != window.clickerVoltAdminBarPosition) {
            window.clickerVoltAdminBarPosition = cvAdminBarPosition;

            ClickerVoltStatsFunctions.updateFixedHeader();
        }
    }

    /**
     * 
     */
    function getAdminBarFixedOffset() {
        var headerOffset = 0;
        if (jQuery('#wpadminbar').css('position') == 'fixed') {
            headerOffset = jQuery('#wpadminbar').outerHeight();
        }
        return headerOffset;
    }

    /**
     * 
     */
    function initLinksTable() {

        var options = {};
        var optionsSlugIcons = {};

        optionsSlugIcons[clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_WHICH_SEGMENT] = clickerVoltVars.const.ReportingSegments.TYPE_LINK;
        optionsSlugIcons[clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS] = [{
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_ICON]: "edit",
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_TITLE]: "Edit",
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_CALLBACK]: function(segmentValue, $element) {
                    if (segmentValue !== undefined) {
                        editSlugClicked($element, segmentValue);
                    }
                }
            },
            {
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_ICON]: "reports",
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_TITLE]: "Open link stats",
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_CALLBACK]: function(segmentValue, $element) {
                    if (segmentValue !== undefined) {
                        openLinkStats($element, segmentValue);
                    }
                }
            },
            {
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_ICON]: "delete",
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_TITLE]: "Delete link",
                [clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS_DETAILS_WHICH_CALLBACK]: function(segmentValue, $element) {
                    if (segmentValue !== undefined) {
                        ClickerVoltModals.confirm(`Are you sure you want to delete this link: '${segmentValue}'?<br><br>This cannot be reversed`, function() {
                            deleteSlug(segmentValue);
                        });
                    }
                }
            }
        ]

        options[clickerVoltVars.const.AjaxStats.OPTION_INCLUDE_SLUGS_WITHOUT_TRAFFIC] = true;
        options[clickerVoltVars.const.AjaxStats.OPTION_SEGMENT_ICONS] = [optionsSlugIcons];

        var table = ClickerVoltStatsFunctions.initStatsTable({
            containerSelector: '#datatables-links',
            segmentColumnName: 'Links',
            ajaxSource: 'wp_ajax_clickervolt_get_stats',
            ajaxData: {
                segments: [
                    clickerVoltVars.const.ReportingSegments.TYPE_LINK,
                    clickerVoltVars.const.ReportingSegments.TYPE_URL,
                ],
                options: options
            },
            datePickerSyncGroup: 'stats',
            datePickerSelector: 'input[name="links-daterange"]',
            onDateChanged: function(start, end) {
                table.ajax.reload(ClickerVoltStatsFunctions.updateFixedHeader);
            },
            // dataTableOptions: {
            //     select: {
            //         style: 'single',
            //         selector: 'td:not(:first-child)'
            //     },
            // }
        });

        jQuery('.links-toolbar')
            .appendTo(jQuery('#datatables-links').parent().find('div.stats-table-toolbar'))
            .show();

        jQuery('#btn-links-refresh').on('click', function() {
            forceProcessClicksQueue(function() {
                jQuery('#datatables-links').DataTable().ajax.reload(ClickerVoltStatsFunctions.updateFixedHeader);
            });
        });

        ClickerVoltStatsFunctions.enableHeatmap(jQuery('#datatables-links'), ClickerVoltStatsFunctions.COLUMN_PROFIT, true);

        return table;
    }

    /**
     * 
     */
    function deleteSlug(slug) {

        ClickerVoltFunctions.ajax('wp_ajax_clickervolt_delete_link_by_slug', null, {

            data: {
                slug: slug
            },
            success: function() {
                ClickerVoltLinkController.refreshLinksLists();
                jQuery('#datatables-links').DataTable().ajax.reload(ClickerVoltStatsFunctions.updateFixedHeader);
            },
            complete: function() {}
        });
    }

    /**
     * 
     */
    function openLinkStats($element, slug) {

        var htmlBackup = $element.html();
        var replaceFrom = '<i class="material-icons stats-row reports"></i>';

        var pluginUrl = clickerVoltVars.urls.plugin;
        var loadingImageUrl = pluginUrl + '/admin/images/icons/report-loading-18px.gif?v=2';
        var replaceTo = `<img src='${loadingImageUrl}' style='position: relative; top: 4px; left: 0px;' />`;

        $element.prop('disabled', true).html(htmlBackup.replace(replaceFrom, replaceTo));

        ClickerVoltFunctions.ajax('wp_ajax_clickervolt_get_link_by_slug', null, {
            data: {
                slug: slug
            },
            success: function(link) {

                jQuery('#segment-views-select').val('').trigger('change');
                jQuery('#link-filter').val(link['id']).trigger('change');
                jQuery('#source-filter').val('').trigger('change');

                var $linksDatePicker = jQuery('input[name="links-daterange"]');
                var startDate = $linksDatePicker.data('daterangepicker').startDate;
                var endDate = $linksDatePicker.data('daterangepicker').endDate;

                var $reportsDatePicker = jQuery('input[name="reports-daterange"]');
                $reportsDatePicker.data('daterangepicker').setStartDate(startDate);
                $reportsDatePicker.data('daterangepicker').setEndDate(endDate);

                var hasFunnelLinks = false;
                if (link.settings.funnelLinks &&
                    link.settings.funnelLinks.length > 0) {
                    hasFunnelLinks = true;
                } else if (link.settings.voltifyOptions &&
                    link.settings.voltifyOptions.linkReplacements &&
                    Object.keys(link.settings.voltifyOptions.linkReplacements).length > 0) {
                    hasFunnelLinks = true;
                }

                if (hasFunnelLinks) {
                    refreshSegments("Source > Funnel Links");
                } else {
                    refreshSegments("Source > URL");
                }

                refreshDrilldownReport(function() {
                    ClickerVoltFunctions.selectTab('#tabs-for-stats', 'tab-reports');
                    jQuery('html,body').animate({
                        scrollTop: 0
                    }, 'slow');
                    $element.prop('disabled', false).html(htmlBackup);
                });

            },
            complete: function() {}
        });
    }

    /**
     * 
     */
    function editSlugClicked($element, slug) {

        var htmlBackup = $element.html();
        var replaceFrom = '<i class="material-icons stats-row edit"></i>';

        var pluginUrl = clickerVoltVars.urls.plugin;
        var loadingImageUrl = pluginUrl + '/admin/images/icons/loading-18px.gif?v=2';
        var replaceTo = `<img src='${loadingImageUrl}' style='position: relative; top: 4px; left: 0px;' />`;

        $element.prop('disabled', true).html(htmlBackup.replace(replaceFrom, replaceTo));

        ClickerVoltLinkController.loadSlugFromSlugName(slug, null, function() {
            $element.prop('disabled', false).html(htmlBackup);
            jQuery("#options-accordion").accordion('option', 'active', 0);
            jQuery('html,body').animate({
                scrollTop: 0
            }, 'fast');
        });
    }

    function changeLinksRefreshButtonToApply() {
        changeRefreshButtonToApply('#btn-links-refresh');
    }

    function changeLinksApplyButtonToRefresh() {
        changeApplyButtonToRefresh('#btn-links-refresh');
    }

    function changeRefreshButtonToApply(buttonSelector) {
        jQuery(buttonSelector).html('<i class="material-icons for-button apply"></i>Apply').addClass('green');
    }

    function changeApplyButtonToRefresh(buttonSelector) {
        jQuery(buttonSelector).html('<i class="material-icons for-button refresh"></i>Refresh').removeClass('green');
    }

    /**
     * 
     */
    function initStatButtons() {

        jQuery('button.stat-button').each(function() {

            var $button = jQuery(this);
            var list = $button.attr('list');
            if (list) {
                var id = ClickerVoltFunctions.uuid();
                var tags = [
                    `<div id="${id}" class="jq-dropdown jq-dropdown-tip jq-dropdown-relative">`,
                    '<ul class="jq-dropdown-menu">'
                ];

                var subItems = list.split('|');
                for (var i = 0; i < subItems.length; i++) {
                    tags.push(`<li><a class="stat-button">${subItems[i]}</a></li>`);
                }

                tags.push('</ul></div>');
                var html = tags.join('');
                jQuery(html).insertAfter($button);

                $button.addClass('not-triggerable');
                $button.attr('data-jq-dropdown', `#${id}`);
                $button.append('<i class="material-icons for-button dropdown"></i>');
            }
        });

        jQuery('.stat-button:not(.not-triggerable)').on('click', function() {
            var name = jQuery(this).text();
            refreshSegments(name);
        });

        jQuery('#btn-stats-refresh').on('click', function() {
            var $button = jQuery(this);
            $button.prop('disabled', true);
            forceProcessClicksQueue(function() {
                refreshDrilldownReport(function() {
                    $button.prop('disabled', false);
                });
            });
        });
    }

    /**
     * 
     */
    function forceProcessClicksQueue(onComplete) {
        ClickerVoltFunctions.ajax('wp_ajax_clickervolt_process_clicks_queue', null, {
            success: function() {
                if (onComplete) {
                    onComplete();
                }
            }
        });
    }
</script>