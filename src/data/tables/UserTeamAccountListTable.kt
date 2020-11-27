package com.alphadevelopmentsolutions.data.tables

import com.alphadevelopmentsolutions.data.models.UserTeamAccountList
import com.google.gson.annotations.SerializedName
import org.jetbrains.exposed.sql.ResultRow

object UserTeamAccountListTable : ModifyTrackedTable<UserTeamAccountList>("user_team_account_list") {
    var userId = binary("user_id", 16)
    var teamAccountId = binary("team_account_id", 16)
    var state = customEnumeration("state", "ENUM('ENABLED', 'DISABLED')", { value -> UserTeamAccountList.Companion.State.valueOf(value as String)}, { it.name })
    override fun fromResultRow(resultRow: ResultRow): UserTeamAccountList {
        TODO("Not yet implemented")
    }
}