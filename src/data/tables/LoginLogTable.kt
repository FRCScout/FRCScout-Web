package com.alphadevelopmentsolutions.data.tables

object LoginLogTable : ByteArrayTable("login_logs") {
    var username = varchar("username", 20).nullable()
    var password = varchar("password", 100).nullable()
    var ip = integer("ip")
    var time = datetime("time")
    var userAgent = varchar("user_agent", 100)
    var userId = binary("user_id", 16).nullable()
}