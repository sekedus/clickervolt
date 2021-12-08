<div id="tab-reports" class="tab-content">

    <div id="reports-header">

        <div class="stat-buttons-shortcuts">
            <button class="button stat-button" list="Funnel Links|Funnel Links > URL|Source > Funnel Links|Source > URL > Funnel Links|Source > Suspicious VS Clean > Funnel Links">Funnel Links</button>
            <button class="button stat-button" list="Source|Source > Suspicious VS Clean|Source > Suspicious Buckets|Source > URL|Source > V1|Source > V2|Source > V3|Source > V4|Source > V5|Source > V6|Source > V7|Source > V8|Source > V9|Source > V10">Source</button>
            <button class="button stat-button" list="V1|V2|V3|V4|V5|V6|V7|V8|V9|V10">Source Vars</button>
            <button class="button stat-button" list="Suspicious VS Clean|Suspicious Buckets">Suspicious Traffic</button>
            <button class="button stat-button">URL</button>
            <button class="button stat-button" list="Device Type|Device Brand|Device Name">Device</button>
            <button class="button stat-button" list="OS Name|OS Version">OS</button>
            <button class="button stat-button" list="Browser Name|Browser Version">Browser</button>
            <button class="button stat-button" list="Country|Country > Region|Country > City > ZIP|Country Tier > Country|Timezone">Geo</button>
            <button class="button stat-button">Language</button>
            <!-- <button class="button stat-button" list="Connection Type|ISP|Proxy|Connection Type > ISP">Connection</button> -->
            <button class="button stat-button">ISP</button>
            <button class="button stat-button" list="IP-Range 1.2.3.xxx|IP-Range 1.2.xxx.xxx">IP</button>
            <button class="button stat-button" list="Referrer Domain|Referrer URL">Referrer</button>
            <button class="button stat-button" list="Date|Day of Week|Hour of Day">Time</button>
        </div>

        <table id="segments-and-controls">
            <tbody>
                <tr>
                    <td>
                        <div class="segment-selects">
                            <span class="segment-filters">
                                <select class="segment-filter" id='link-filter'></select>
                                <select class="segment-filter" id='source-filter'>
                                    <option value='' reserved="true">All Sources</option>
                                </select>
                            </span>

                            <span class="segments">
                                <select class="segment-select" id='segment1'>
                                    <option value='' reserved="true">Choose segment 1</option>
                                </select>
                                <select class="segment-select" id='segment2'>
                                    <option value='' reserved="true">Choose segment 2</option>
                                </select>
                                <select class="segment-select" id='segment3'>
                                    <option value='' reserved="true">Choose segment 3</option>
                                </select>
                            </span>

                            <span class="segment-views">
                                <select class='segment-views-select' id='segment-views-select'>
                                    <option value='' reserved="true">Custom Reports</option>
                                </select>
                                <span class="segment-views-actions">
                                    <i id="segment-view-save" class="material-icons inline-save" title="Save Report"></i>
                                    <i id="segment-view-delete" class="material-icons inline-delete" title="Delete Report"></i>
                                </span>
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <span class="reports-toolbar" style="display: none;">
            <button id="btn-stats-refresh" class="button button-primary"><i class="material-icons for-button refresh"></i>Refresh</button>
            <input class="daterange" type="text" name="reports-daterange" readonly />
            <select class="heatmap" for="#datatables-reports"></select>
        </span>

    </div>

    <table id="datatables-reports" class="reporting-table stats-table-with-fixed-header"></table>
</div>

<script>
    /**
     * 
     */
    function refreshSegments(name) {
        resetSegments(false);

        name = removeSourceVarName(name);
        switch (name) {
            case "Source > URL":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_URL);
                break;

            case "Source > Suspicious VS Clean":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_SUSPICIOUS_VS_CLEAN);
                break;

            case "Source > Suspicious Buckets":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_SUSPICIOUS_BUCKETS);
                break;

            case "Source > V1":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_1);
                break;

            case "Source > V2":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_2);
                break;

            case "Source > V3":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_3);
                break;

            case "Source > V4":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_4);
                break;

            case "Source > V5":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_5);
                break;

            case "Source > V6":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_6);
                break;

            case "Source > V7":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_7);
                break;

            case "Source > V8":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_8);
                break;

            case "Source > V9":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_9);
                break;

            case "Source > V10":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_10);
                break;

            case "Source":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                break;

            case "V1":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_1);
                break;

            case "V2":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_2);
                break;

            case "V3":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_3);
                break;

            case "V4":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_4);
                break;

            case "V5":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_5);
                break;

            case "V6":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_6);
                break;

            case "V7":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_7);
                break;

            case "V8":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_8);
                break;

            case "V9":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_9);
                break;

            case "V10":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_VAR_10);
                break;

            case "URL":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_URL);
                break;

            case "Funnel Links":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_FUNNEL_LINK);
                break;

            case "Funnel Links > URL":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_FUNNEL_LINK);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_URL);
                break;

            case "Source > Funnel Links":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_FUNNEL_LINK);
                break;

            case "Source > URL > Funnel Links":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_URL);
                jQuery("#segment3").val(clickerVoltVars.const.ReportingSegments.TYPE_FUNNEL_LINK);
                break;

            case "Source > Suspicious VS Clean > Funnel Links":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_SUSPICIOUS_VS_CLEAN);
                jQuery("#segment3").val(clickerVoltVars.const.ReportingSegments.TYPE_FUNNEL_LINK);
                break;

            case "Suspicious VS Clean":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SUSPICIOUS_VS_CLEAN);
                break;

            case "Suspicious Buckets":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SUSPICIOUS_BUCKETS);
                break;

            case "Device Type":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_TYPE);
                break;

            case "Device Brand":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_BRAND);
                break;

            case "Device Name":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_NAME);
                break;

            case "OS Name":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_OS);
                break;

            case "OS Version":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_OS_VERSION);
                break;

            case "Browser Name":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_BROWSER);
                break;

            case "Browser Version":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_BROWSER_VERSION);
                break;

            case "Country":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_COUNTRY);
                break;

            case "Country > Region":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_COUNTRY);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_REGION);
                break;

            case "Country > City > ZIP":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_COUNTRY);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_CITY);
                jQuery("#segment3").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_ZIP);
                break;

            case "Country Tier > Country":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_COUNTRY_TIER);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_COUNTRY);
                break;

            case "Timezone":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_GEO_TIMEZONE);
                break;

            case "Language":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_LANGUAGE);
                break;

            case "ISP":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_CONNECTION_ISP);
                break;

            case "Proxy":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_CONNECTION_PROXY);
                break;

            case "Connection Type":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_CONNECTION_CELLULAR);
                break;

            case "Connection Type > ISP":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_CONNECTION_CELLULAR);
                jQuery("#segment2").val(clickerVoltVars.const.ReportingSegments.TYPE_CONNECTION_ISP);
                break;

            case "IP-Range 1.2.3.xxx":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_IP_RANGE_C);
                break;

            case "IP-Range 1.2.xxx.xxx":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_IP_RANGE_B);
                break;

            case "Referrer Domain":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_REFERRER_DOMAIN);
                break;

            case "Referrer URL":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_REFERRER);
                break;

            case "Date":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_TIME_DATES);
                break;

            case "Day of Week":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_TIME_DAY_OF_WEEK);
                break;

            case "Hour of Day":
                jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_TIME_HOUR_OF_DAY);
                break;
        }

        jQuery('.segment-select').trigger('change');
    }

    /**
     * 
     * @return { id1: name1, id2: name2, etc... }
     */
    function getSegments(varNameSuffixes) {

        if (!varNameSuffixes) {
            varNameSuffixes = {};
        }

        var segments = [
            clickerVoltVars.const.ReportingSegments.TYPE_FUNNEL_LINK,
            clickerVoltVars.const.ReportingSegments.TYPE_SOURCE,
            clickerVoltVars.const.ReportingSegments.TYPE_SUSPICIOUS_VS_CLEAN,
            clickerVoltVars.const.ReportingSegments.TYPE_SUSPICIOUS_BUCKETS,
            clickerVoltVars.const.ReportingSegments.TYPE_URL,
            clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_TYPE,
            clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_BRAND,
            clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_NAME,
            clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_OS,
            clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_OS_VERSION,
            clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_BROWSER,
            clickerVoltVars.const.ReportingSegments.TYPE_DEVICE_BROWSER_VERSION,
            clickerVoltVars.const.ReportingSegments.TYPE_GEO_COUNTRY,
            clickerVoltVars.const.ReportingSegments.TYPE_GEO_COUNTRY_TIER,
            clickerVoltVars.const.ReportingSegments.TYPE_GEO_REGION,
            clickerVoltVars.const.ReportingSegments.TYPE_GEO_CITY,
            clickerVoltVars.const.ReportingSegments.TYPE_GEO_ZIP,
            clickerVoltVars.const.ReportingSegments.TYPE_GEO_TIMEZONE,
            clickerVoltVars.const.ReportingSegments.TYPE_LANGUAGE,
            clickerVoltVars.const.ReportingSegments.TYPE_CONNECTION_ISP,
            // clickerVoltVars.const.ReportingSegments.TYPE_CONNECTION_PROXY,
            // clickerVoltVars.const.ReportingSegments.TYPE_CONNECTION_CELLULAR,
            clickerVoltVars.const.ReportingSegments.TYPE_IP_RANGE_C,
            clickerVoltVars.const.ReportingSegments.TYPE_IP_RANGE_B,
            clickerVoltVars.const.ReportingSegments.TYPE_REFERRER,
            clickerVoltVars.const.ReportingSegments.TYPE_REFERRER_DOMAIN,
            clickerVoltVars.const.ReportingSegments.TYPE_TIME_DATES,
            clickerVoltVars.const.ReportingSegments.TYPE_TIME_DAY_OF_WEEK,
            clickerVoltVars.const.ReportingSegments.TYPE_TIME_HOUR_OF_DAY,
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_1 + (varNameSuffixes['V1'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_2 + (varNameSuffixes['V2'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_3 + (varNameSuffixes['V3'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_4 + (varNameSuffixes['V4'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_5 + (varNameSuffixes['V5'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_6 + (varNameSuffixes['V6'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_7 + (varNameSuffixes['V7'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_8 + (varNameSuffixes['V8'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_9 + (varNameSuffixes['V9'] || ''),
            clickerVoltVars.const.ReportingSegments.TYPE_VAR_10 + (varNameSuffixes['V10'] || ''),
        ];

        return segments;
    }

    /**
     * 
     */
    function refreshVarNames() {

        var sourceId = jQuery('#source-filter option:selected').val();
        var varNameSuffixes = {
            'V1': '',
            'V2': '',
            'V3': '',
            'V4': '',
            'V5': '',
            'V6': '',
            'V7': '',
            'V8': '',
            'V9': '',
            'V10': '',
        };

        if (sourceId) {
            var sourceTemplates = ClickerVoltFunctions.getOption('sourceTemplates', jQuery('#source-filter'));
            var source = sourceTemplates[sourceId];
            if (source) {
                varNameSuffixes['V1'] = getSourceVarNameSuffix(source['v1Name']);
                varNameSuffixes['V2'] = getSourceVarNameSuffix(source['v2Name']);
                varNameSuffixes['V3'] = getSourceVarNameSuffix(source['v3Name']);
                varNameSuffixes['V4'] = getSourceVarNameSuffix(source['v4Name']);
                varNameSuffixes['V5'] = getSourceVarNameSuffix(source['v5Name']);
                varNameSuffixes['V6'] = getSourceVarNameSuffix(source['v6Name']);
                varNameSuffixes['V7'] = getSourceVarNameSuffix(source['v7Name']);
                varNameSuffixes['V8'] = getSourceVarNameSuffix(source['v8Name']);
                varNameSuffixes['V9'] = getSourceVarNameSuffix(source['v9Name']);
                varNameSuffixes['V10'] = getSourceVarNameSuffix(source['v10Name']);
            }
        }

        jQuery('ul.jq-dropdown-menu li a').each(function() {
            var text = removeSourceVarName(jQuery(this).text());
            for (varNum in varNameSuffixes) {
                if (text.match(new RegExp(`(|\s)${varNum}(\s|$)`))) {
                    jQuery(this).text(text.replace(varNum, varNum + varNameSuffixes[varNum]));
                }
            }
        });

        initSegmentSelects(varNameSuffixes);
    }

    function getSourceVarNameSeparator() {
        return ': ';
    }

    function getSourceVarNameSuffix(varName) {
        if (varName) {
            return getSourceVarNameSeparator() + varName
        }

        return '';
    }

    /**
     * 
     */
    function removeSourceVarName(text) {

        var index = text.indexOf(getSourceVarNameSeparator());
        if (index != -1) {
            text = text.substring(0, index);
        }

        return text;
    }

    /**
     * 
     */
    function setRequestSegments(data) {

        var seg0 = clickerVoltVars.const.ReportingSegments.TYPE_LINK;
        var seg1 = jQuery("#segment1 option:selected").val();
        var seg2 = jQuery("#segment2 option:selected").val();
        var seg3 = jQuery("#segment3 option:selected").val();

        if (seg0) {
            data.segments.push(seg0);
        }
        if (seg1) {
            data.segments.push(seg1);
        }
        if (seg2) {
            data.segments.push(seg2);
        }
        if (seg3) {
            data.segments.push(seg3);
        }

        data.linkIdFilter = jQuery('#link-filter option:selected').val();
        data.sourceIdFilter = jQuery('#source-filter option:selected').val();
    }

    /**
     * 
     */
    function refreshDrilldownReport(onComplete) {
        var dt = jQuery('#datatables-reports').DataTable();
        dt.ajax.reload(function() {
            changeReportApplyButtonToRefresh();
            ClickerVoltStatsFunctions.expandAll(jQuery('#datatables-reports'));

            if (onComplete) {
                onComplete();
            }
        });
    }

    /** 
     * @param bool triggerChange
     */
    function resetSegments(triggerChange) {
        jQuery("#segment1").val("");
        jQuery("#segment2").val("");
        jQuery("#segment3").val("");

        if (triggerChange) {
            jQuery('.segment-select').trigger('change');
        }
    }

    /**
     * 
     */
    function initReportsTable() {

        initReportsFilters();
        initSegmentSelects();
        jQuery("#segment1").val(clickerVoltVars.const.ReportingSegments.TYPE_SOURCE).trigger('change');

        var table = ClickerVoltStatsFunctions.initStatsTable({
            containerSelector: '#datatables-reports',
            ajaxSource: 'wp_ajax_clickervolt_get_stats',
            ajaxData: {
                segments: [],
                linkIdFilter: clickerVoltVars.const.ReportTypes.LINKS_ALL_AGGREGATED,
            },
            ajaxDataCallback: function(d) {
                setRequestSegments(d);
            },
            ajaxRenderedCallback: function(rows, ajaxData) {
                if (!window.clickerVoltVars.initReportsTableRenderedAtLeastOnce) {
                    window.clickerVoltVars.initReportsTableRenderedAtLeastOnce = true;
                    ClickerVoltStatsFunctions.expandAll(jQuery('#datatables-reports'));
                }
            },
            datePickerSyncGroup: 'stats',
            datePickerSelector: 'input[name="reports-daterange"]',
            onDateChanged: function(start, end) {
                changeReportRefreshButtonToApply();
            }
        });

        ClickerVoltStatsFunctions.enableHeatmap(jQuery('#datatables-reports'), ClickerVoltStatsFunctions.COLUMN_PROFIT, true);

        initStatButtons();
        initReportsHeader();
        changeReportApplyButtonToRefresh();

        return table;
    }

    /**
     * 
     */
    function initReportsHeader() {
        jQuery('.reports-toolbar')
            .appendTo(jQuery('#datatables-reports').parent().find('div.stats-table-toolbar'))
            .show();
    }

    /**
     * 
     */
    function initReportsFilters() {

        initSlugFilter();
        initSourceSelect(jQuery('#source-filter'), 'segment-filter');
        initCustomReports();

        jQuery('.segment-filter').on('change', function() {
            changeReportRefreshButtonToApply();
        });
    }

    /**
     * 
     */
    function cacheCustomReport(reportId, reportName, linkId, sourceId, segments) {
        if (!window.clickerVoltCustomReports) {
            window.clickerVoltCustomReports = {};
        }
        window.clickerVoltCustomReports[reportId] = {
            name: reportName,
            linkId: linkId,
            sourceId: sourceId,
            segments: segments,
        };
    }

    /** 
     * 
     */
    function getCachedCustomReport(reportId) {
        if (!window.clickerVoltCustomReports) {
            window.clickerVoltCustomReports = {};
        }
        return window.clickerVoltCustomReports[reportId];
    }

    /** 
     * 
     */
    function getCachedCustomReports() {
        if (!window.clickerVoltCustomReports) {
            window.clickerVoltCustomReports = {};
        }
        return window.clickerVoltCustomReports;
    }

    /** 
     * 
     */
    function populateCustomReportsFromCache(reportIdToSelect) {
        var $select = jQuery('#segment-views-select');

        $select.find('option').each(function() {
            var $option = jQuery(this);
            if (!$option.attr('reserved')) {
                $option.remove();
            }
        });

        var reports = getCachedCustomReports();
        for (var id in reports) {
            var name = reports[id]['name'];
            $select.append(`<option value="${id}">${name}</option>`);
        }

        ClickerVoltFunctions.initSelect2($select, {
            theme: 'default segment-views-select'
        });

        if (reportIdToSelect) {
            $select.val(reportIdToSelect);
        }

        $select.off('change', customReportChanged);
        $select.on('change', customReportChanged);
        $select.trigger('change');
    }

    /**
     * 
     */
    function initCustomReports() {
        ClickerVoltFunctions.ajax('wp_ajax_clickervolt_get_all_custom_reports', null, {
            success: function(reports) {
                for (var id in reports) {
                    cacheCustomReport(id, reports[id]['name'], reports[id]['linkId'], reports[id]['sourceId'], reports[id]['segments']);
                }
                populateCustomReportsFromCache();
            },
            complete: function() {}
        });

        jQuery('#segment-view-delete').off('click', deleteCustomReport);
        jQuery('#segment-view-delete').on('click', deleteCustomReport);

        jQuery('#segment-view-save').off('click', saveCustomReport);
        jQuery('#segment-view-save').on('click', saveCustomReport);
    }

    /** 
     * 
     */
    function deleteCustomReport() {
        var reportId = jQuery('#segment-views-select option:selected').val();
        var reportName = jQuery('#segment-views-select option:selected').text();

        ClickerVoltModals.confirm(`Are you sure you want to delete this report: '${reportName}'?<br><br>This cannot be reversed`, function() {
            ClickerVoltFunctions.ajax('wp_ajax_clickervolt_delete_custom_report', null, {
                data: {
                    id: reportId
                },
                success: function() {
                    delete window.clickerVoltCustomReports[reportId];
                    populateCustomReportsFromCache();
                },
                complete: function() {}
            });
        });
    }

    /** 
     * 
     */
    function saveCustomReport() {
        var reportId = jQuery('#segment-views-select option:selected').val();
        var reportName = '';

        var save = function(jc, reportId) {
            var newName = jc.$content.find('.name').val();
            if (!newName) {
                ClickerVoltModals.message('Please enter a valid name', '');
                return false;
            }
            var segments = [];
            var segment1 = jQuery('#segment1 option:selected').val();
            var segment2 = jQuery('#segment2 option:selected').val();
            var segment3 = jQuery('#segment3 option:selected').val();
            if (segment1) {
                segments.push(segment1);
            }
            if (segment2) {
                segments.push(segment2);
            }
            if (segment3) {
                segments.push(segment3);
            }

            var data = {
                id: reportId,
                name: newName,
                linkId: jQuery('#link-filter option:selected').val(),
                sourceId: jQuery('#source-filter option:selected').val(),
                segments: segments,
            };

            ClickerVoltFunctions.ajax('wp_ajax_clickervolt_save_custom_report', null, {
                data: data,
                success: function(response) {
                    cacheCustomReport(response.id, response.name, response.linkId, response.sourceId, response.segments);
                    populateCustomReportsFromCache(response.id);
                },
                complete: function() {}
            });
        }

        var buttons = {
            createNewReport: {
                text: 'Create New',
                btnClass: 'btn-blue',
                action: function() {
                    return save(this, null);
                }
            },
        };

        if (reportId) {
            reportName = jQuery('#segment-views-select option:selected').text();

            buttons['updateExistingReport'] = {
                text: 'Update Selected',
                btnClass: 'btn-purple',
                action: function() {
                    return save(this, reportId);
                }
            };
        }

        buttons['cancel'] = function() {
            // close
        }

        jQuery.confirm(ClickerVoltModals.getConfirmOptions({
            title: 'Report Name',
            content: '' +
                '<form action="" class="">' +
                '<div class="form-group">' +
                `<input type="text" placeholder="" class="name form-control" required style="width: 90%;" value="${reportName}" />` +
                '</div>' +
                '</form>',
            buttons: buttons,
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                });
            }
        }));
    }

    /**
     * 
     */
    function customReportChanged() {
        resetSegments(false);
        jQuery('#link-filter').val(clickerVoltVars.const.ReportTypes.LINKS_ALL_AGGREGATED).trigger('change');
        jQuery('#source-filter').val('').trigger('change');
        jQuery('#segment-view-delete').hide();

        var $select = jQuery('#segment-views-select');
        var id = $select.find('option:selected').val();
        if (id) {
            var customReport = getCachedCustomReport(id);
            if (customReport) {
                jQuery('#link-filter').val(customReport.linkId).trigger('change');
                jQuery('#source-filter').val(customReport.sourceId).trigger('change');
                jQuery('#segment-view-delete').show();

                for (var i = 0; i < customReport.segments.length; i++) {
                    var segmentElem = `#segment${i+1}`;
                    jQuery(segmentElem).val(customReport.segments[i]);
                }
            }
        }
        jQuery('.segment-select').trigger('change');
    }

    /**
     * 
     */
    function initSlugFilter() {

        var $select = jQuery('#link-filter');

        $select.find('option').each(function() {
            var $option = jQuery(this);
            if (!$option.attr('reserved')) {
                $option.remove();
            }
        });

        $select.append(`<option selected="true" value="${clickerVoltVars.const.ReportTypes.LINKS_ALL_AGGREGATED}">All Links (Aggregated)</option>`);
        $select.append(`<option value="${clickerVoltVars.const.ReportTypes.LINKS_ALL_SEPARATED}">All Links (Separated)</option>`);

        ClickerVoltFunctions.ajax('wp_ajax_clickervolt_get_all_slugs', null, {

            success: function(slugInfos) {

                for (var i = 0; i < slugInfos.length; i++) {
                    var id = slugInfos[i]['id'];
                    var slug = slugInfos[i]['slug'];
                    $select.append(`<option value="${id}">${slug}</option>`);
                }

                ClickerVoltFunctions.initSelect2($select, {
                    theme: 'default segment-filter'
                });
            },
            complete: function() {}
        });
    }

    /**
     * @param object $select
     * @param string classesToAdd
     */
    function initSourceSelect($select, classesToAdd) {

        $select.find('option').each(function() {
            var $option = jQuery(this);
            if (!$option.attr('reserved')) {
                $option.remove();
            }
        });

        ClickerVoltFunctions.ajax('wp_ajax_clickervolt_get_sources', null, {

            success: function(response) {

                var sources = response.sources;
                ClickerVoltFunctions.setOption('sourceTemplates', sources, $select);

                for (var sourceId in sources) {
                    var name = sources[sourceId]['sourceName'];
                    $select.append(`<option value="${sourceId}">${name}</option>`);
                }

                if (!classesToAdd) {
                    classesToAdd = '';
                }

                ClickerVoltFunctions.initSelect2($select, {
                    theme: `default ${classesToAdd}`
                });
            },
            complete: function() {}
        });

        $select.off('change', refreshVarNames);
        $select.on('change', refreshVarNames);
    }

    /**
     * 
     */
    function initSegmentSelects(varNameSuffixes) {

        var $select = jQuery('select.segment-select');

        var selectedOptions = {};
        $select.each(function(index) {
            selectedOptions[index] = jQuery(this).find('option:selected').val();
        })

        $select.find('option').each(function() {
            var $option = jQuery(this);
            if (!$option.attr('reserved')) {
                $option.remove();
            }
        });

        var segments = getSegments(varNameSuffixes);
        for (var i = 0; i < segments.length; i++) {
            var segmentId = removeSourceVarName(segments[i]);
            var segmentName = segments[i];
            $select.append(`<option value="${segmentId}">${segmentName}</option>`);
        }

        ClickerVoltFunctions.initSelect2($select);

        $select.each(function(index) {
            jQuery(this).val(selectedOptions[index]).trigger('change');
        })

        $select.off('change', changeReportRefreshButtonToApply);
        $select.on('change', changeReportRefreshButtonToApply);
    }

    function changeReportRefreshButtonToApply() {
        changeRefreshButtonToApply('#btn-stats-refresh');
    }

    function changeReportApplyButtonToRefresh() {
        changeApplyButtonToRefresh('#btn-stats-refresh');
    }
</script>