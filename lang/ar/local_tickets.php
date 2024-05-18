<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language Strings
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 $string['all'] = 'الكل';
 $string['closed'] = 'مغلق';
 $string['closed_comments_message'] = "تم إغلاق التعليقات، ولكن يمكنك التعليق حيث أنك مسؤول.";
 $string['comment'] = 'تعليق';
 $string['comments'] = 'تعليقات';
 $string['created_at'] = 'تم الإنشاء في';
 $string['created_by'] = 'تم الإنشاء بواسطة';
 $string['description'] = 'الوصف';
 $string['failovertrackerurl_help'] = '
 استخدام المتتبع داخل Moodle قد لا يكون كافيًا في حالة عدم توافر Moodle ذاتيًا أو عند عدم عمله بشكل صحيح. عند تقديم رابط متتبع الفشل،
 ستقدم للمستخدمين معلومات حول عنوان URL البديل الذي يمكنهم استخدامه في حالات الطوارئ. سيتم دعوة المستخدمين إلى حفظ الرابط البديل في ملفاتهم
 الشخصية للوصول إليه عند الحاجة.
 ';
 $string['failovertrackerurl_tpl'] = '
 في حالة عدم توفر هذا المتتبع أو عدم توافره، يمكنك نشر إشارة في <a href="{$a}">متتبع الطوارئ</a>.
 يجب عليك حفظ هذا الرابط
 للحصول على الرابط المتاح حتى إذا كان Moodle متوقفًا أو لا يعمل بشكل صحيح.
 ';
 $string['filter_by_user_help'] = 'هوية المستخدم';
 $string['id'] = 'الرقم التعريفي';
 $string['invalidmobile'] = 'رقم جوال غير صحيح';
 $string['last_updated_at'] = 'آخر تحديث في';
 $string['last_updated_by'] = 'آخر تحديث بواسطة';
 $string['manage_tickets'] = 'إدارة التذاكر';
 $string['mobile'] = 'الجوال';
 $string['mobile_help'] = '
 مثال:
 +962555555555';
 $string['modulename'] = 'دعم التذاكر';
 $string['networkable_help'] = 'إذا تم تمكينه، سيتم عرض هذا المتتبع علانية للموقع البعيد. سيتمكن المستخدمون من المواقع البعيدة
 من المشاركة حتى لو لم يكونوا لديهم حسابات محلية. سيتم إنشاء حساب Mnet على الفور. سيكون هذا ممكنًا فقط
 إذا تم تكوين خدمات Mnet للمتتبع بشكل صحيح من كلا الجانبين.';
 $string['new_ticket_submitted'] = 'تم تقديم تذكرة جديدة';
 $string['num_records'] = '{$a} سجلات';
 $string['open'] = 'مفتوح';
 $string['operation'] = 'العملية';
 $string['pending'] = 'معلق';
 $string['pluginadministration'] = 'إدارة التذاكر';
 $string['pluginname'] = 'دعم التذاكر';
 $string['post_comment'] = 'نشر تعليق';
 $string['report_date'] = 'تاريخ الإبلاغ';
 $string['reported_by'] = 'المبلغ عنه';
 $string['require_login'] = 'يتطلب تسجيل الدخول';
 $string['require_login_desc'] = 'السماح فقط للمستخدمين المسجلين تقديم التذاكر.';
 $string['send_email_on_comments_add'] = 'تمت إضافة تعليقات';
 $string['send_email_on_comments_add_desc'] = 'إرسال بريد إلكتروني إلى مالك التذكرة عند إضافة تعليقات إلى تذكرتهم.';
 $string['send_email_on_status_change'] = 'تغيير الحالة';
 $string['send_email_on_status_change_desc'] = 'إرسال بريد إلكتروني إلى مالك التذكرة عند تغيير حالة التذكرة.';
 $string['show_widget'] = 'إظهار الودجة';
 $string['show_widget_desc'] = 'إظهار زر الودجة الثابتة في الجزء السفلي الأيسر من الشاشة.';
 $string['solved'] = 'تم حله';
 $string['status'] = 'الحالة';
 $string['strictworkflow_help'] = '
 عند التمكين، سيكون لكل دور داخلي محدد في المتتبع (المبلغ، المطور، الحلول، المدير) فقط الوصول إلى حالاته المتاحة ضد دوره.
 ';
 $string['submit_ticket'] = 'تقديم تذكرة';
 $string['ticket_id'] = 'رقم التذكرة';
 $string['title'] = 'العنوان';
 $string['view_my_tickets'] = 'عرض تذاكري';
 $string['you_have_num_tickets'] = 'لديك {$a} تذكرة.';
 $string['attachments'] = 'المرفقات';
 $string['ticket_submission_success'] = 'تم تقديم التذكرة بنجاح.';
 $string['ticket_submission_fail'] = 'فشل في تقديم التذكرة.';
 $string['status_change_success'] = 'تم تغيير الحالة بنجاح.';
 $string['status_change_fail'] = 'فشل في تغيير الحالة.';
 $string['new_ticket_submitted'] = 'تم تقديم تذكرة جديدة.';
 $string['filter'] = 'تصفية'; 
 $string['my_tickets'] = 'تذاكري';
