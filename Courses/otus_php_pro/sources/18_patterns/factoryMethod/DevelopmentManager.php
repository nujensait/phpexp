<?php


class DevelopmentManager extends HiringManager
{

    protected function makeInterview(): Interviewer
    {
        return new Developer();
    }
}