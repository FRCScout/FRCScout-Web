package com.alphadevelopmentsolutions.data.tables

import com.alphadevelopmentsolutions.data.models.TeamInvitation
import com.alphadevelopmentsolutions.data.models.UserTeamAccountList
import com.google.gson.annotations.SerializedName

object RobotMediaTable : ModifyTrackedTable("robot_media") {
    var teamAccountId = binary("team_account_id", 16)
    var eventId = binary("event_id", 16)
    var teamId = binary("team_id", 16)
    var createdById = binary("created_by_id", 16)
    var uri = varchar("uri", 100)
    var isPublic = bool("is_public")
}