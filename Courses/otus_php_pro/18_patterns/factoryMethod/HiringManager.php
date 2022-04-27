<?php


abstract class HiringManager
{
    // factory method
    abstract protected function makeInterview(): Interviewer;

    public function takeInterview()
    {
        $interviewer = $this->makeInterview();
        $interviewer->askQuestions();
    }
}