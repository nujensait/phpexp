<?php


class CommunityExecutive extends HiringManager
{

    protected function makeInterview(): Interviewer
    {
        return new Comminity();
    }
}