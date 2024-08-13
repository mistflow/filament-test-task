<?php

namespace App;

enum TaskStatus: string
{
    case TODO = 'ToDo';
    case IN_PROGRESS = 'In Progress';
    case DONE = 'Done';

    public static function labels(): array
    {
        return [
            self::TODO->value => 'ToDo',
            self::IN_PROGRESS->value => 'In progress',
            self::DONE->value => 'Done',
        ];
    }

    /**
     * Returns all values of task status itself.
     * @return array
     */
    public static function getValues(): array
    {
        return array_column(TaskStatus::cases(), 'value');
    }
}
