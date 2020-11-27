package com.alphadevelopmentsolutions.data.tables

object ReportFilterTable : ModifyableTable("report_filters") {
    var reportId = binary("report_id", 16)
    var value = varchar("value", 100)
}