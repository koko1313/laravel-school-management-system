<?php

return [
    'error_messages' => [
        'invalid_username_or_password' => 'Невалидно потребителско име или парола.',
        'please_complete_the_recaptcha' => 'Моля попълнете ReCaptcha.',

        'teacher' => [
            'exist' => 'Учител с това име вече съществува.',
            'insert_error' => 'Проблем при добавянето на учителя.',
            'update_error' => 'Проблем при редактирането на учителя.',
            'delete_error' => 'Проблем при изтриването на учителя.',
            'already_class_teacher' => 'Този учител вече ръководи друг клас.',
            'teacher_has_grades' => 'Не може да изтриете този учител, тъй като има ненесени оценки от негово име.'
        ],

        'subject' => [
            'exist' => 'Такъв предмет вече съществува.',
            'insert_error' => 'Проблем при добавянето на предмета.',
            'update_error' => 'Проблем при редактирането на предмета.',
            'delete_error' => 'Проблем при изтриването на предмета.',
            'subject_has_grades' => 'Не може да изтриете този предмет, тъй като има нанесени оценки по него.',
        ],

        'teacher_subject' => [
            'exist' => 'Това разпределение учител-предмет вече съществува.',
            'insert_error' => 'Проблем при добавянето на разпределението учител-предмет.',
            'update_error' => 'Проблем при редактирането на разпределението учител-предмет.',
            'delete_error' => 'Проблем при изтриването на разпределението учител-предмет.',
        ],

        'class' => [
            'exist' => 'Този клас вече съществува.',
            'insert_error' => 'Проблем при добавянето на класа.',
            'update_error' => 'Проблем при редактирането на класа.',
            'delete_error' => 'Проблем при изтриването на класа.',
        ],

        'class_teacher' => [
            'exist' => 'Това разпределение клас-учител вече съществува.',
            'insert_error' => 'Проблем при добавянето на разпределението клас-учител.',
            'update_error' => 'Проблем при редактирането на разпределението клас-учител.',
            'delete_error' => 'Проблем при изтриването на разпределението клас-учител.',
        ],

        'student' => [
            'egn_exist' => 'Вече съществува ученик с това ЕГН',
            'exist' => 'Вече има ученик с този номер в този клас.',
            'insert_error' => 'Проблем при добавянето на ученика.',
            'update_error' => 'Проблем при редактирането на ученика.',
            'delete_error' => 'Проблем при изтриването на ученика.',
        ],

        'school' => [
            'update_term_error' => 'Проблем при промяната на учебния срок.',
            'update_school_details_error' => 'Проблем при промяната на информацията за училището.',
        ],

        'grade' => [
            'exist' => 'Вече съществува оценка за този ученик по този предмет.',
            'insert_error' => 'Проблем при добавянето на оценката.',
            'update_error' => 'Проблем при редактирането на оценката.',
            'delete_error' => 'Проблем при изтриването на оценката.',
        ],
    ],

    'success_messages' => [
        'teacher' => [
            'added' => 'Успешно добавен учител.',
            'updated' => 'Успешно редактиран учител.',
            'deleted' => 'Успешно изтрит учител.',
        ],

        'subject' => [
            'added' => 'Успешно добавен предмет.',
            'updated' => 'Успешно редактиран предмет.',
            'deleted' => 'Успешно изтрит предмет.',
        ],

        'teacher_subject' => [
            'added' => 'Успешно добавено разпределение учител-предмет.',
            'updated' => 'Успешно редактирано разпределение учител-предмет.',
            'deleted' => 'Успешно изтрито разпределение учител-предмет.',
        ],

        'class' => [
            'added' => 'Успешно добавен клас.',
            'updated' => 'Успешно редактиран клас.',
            'deleted' => 'Успешно изтрит клас.',
        ],

        'class_teacher' => [
            'added' => 'Успешно добавено разпределение клас-учител.',
            'updated' => 'Успешно редактирано разпределение клас-учител.',
            'deleted' => 'Успешно изтрито разпределение клас-учител.',
        ],

        'student' => [
            'added' => 'Успешно добавен ученик.',
            'updated' => 'Успешно редактиран ученик.',
            'deleted' => 'Успешно изтрит ученик.',
        ],

        'school' => [
            'term_updated' => 'Учебния срок беше променен успешно.',
            'school_details_updated' => 'Информацията за училището беше променена успешно.',
            'school_year_incremented' => 'Успешно преминахте в следващата учебна година.',
        ],

        'grade' => [
            'added' => 'Оценката беше успешно добавена.',
            'updated' => 'Успешно редактирана оценка.',
            'deleted' => 'Успешно изтрита оценка.',
        ],
    ]
];