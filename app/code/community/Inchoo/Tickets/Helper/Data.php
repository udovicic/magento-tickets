<?php

class Inchoo_Tickets_Helper_Data extends Mage_Core_Helper_Data
{
    const XML_CONFIG_CUSTOMER_NOTIFY_ON_RESPONSE = 'inchoo_tickets/customer_notifications/notify_new_response';
    const XML_CONFIG_ADMIN_NOTIFY_ON_NEW_TICKET = 'inchoo_tickets/admin_notifications/noitfy_new_ticket';
    const XML_CONFIG_ADMIN_NOTIFY_ON_NEW_RESPONSE = 'inchoo_tickets/admin_notifications/notify_admin_response';

    const XML_CONFIG_SENDER_SUBJECT = 'inchoo_tickets/customer_notifications/notify_email_subject';
    const XML_CONFIG_SENDER_SUBJECT_ADMIN_NEW = 'inchoo_tickets/admin_notifications/notify_email_subject_new';
    const XML_CONFIG_SENDER_SUBJECT_ADMIN_RESPOND = 'inchoo_tickets/admin_notifications/notify_email_subject_response';

    const XML_CONFIG_SENDER_TEMPLATE_CUSTOMER = 'inchoo_tickets/customer_notifications/notify_email_template_customer';
    const XML_CONFIG_SENDER_TEMPLATE_ADMIN_NEW = 'inchoo_tickets/admin_notifications/notify_email_template_admin_new';
    const XML_CONFIG_SENDER_TEMPLATE_ADMIN_RESPOND = 'inchoo_tickets/admin_notifications/notify_email_template_admin_respond';

    const XML_CONFIG_SENDER_EMAIL = 'inchoo_tickets/customer_notifications/notify_admin_email';
    const XML_CONFIG_ADMIN_RECEIVE_EMAIL = 'trans_email/ident_general/email';


    /** Save default settings */
    public function saveDefaultSettings($store = null)
    {
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_CUSTOMER_NOTIFY_ON_RESPONSE, 1);
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_ADMIN_NOTIFY_ON_NEW_TICKET, 1);
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_ADMIN_NOTIFY_ON_NEW_RESPONSE, 1);
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_SENDER_SUBJECT, 'Support ticket reply');
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_SENDER_SUBJECT_ADMIN_NEW, 'New support ticket opened');
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_SENDER_SUBJECT_ADMIN_RESPOND, 'Customer submitted new response');
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_SENDER_TEMPLATE_CUSTOMER, 'inchoo_tickets_customer_respond');
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_SENDER_TEMPLATE_ADMIN_NEW, 'inchoo_tickets_admin_new');
        Mage::getModel('core/config')->saveConfig(self::XML_CONFIG_SENDER_TEMPLATE_ADMIN_RESPOND, 'inchoo_tickets_admin_respond');
    }

    /** Notification sending enabled/disabled */
    public function notifyCustomer($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_CUSTOMER_NOTIFY_ON_RESPONSE, $store);
    }

    public function notifyAdminNew($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_ADMIN_NOTIFY_ON_NEW_TICKET, $store);
    }

    public function notifyAdminResponse($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_CUSTOMER_NOTIFY_ON_RESPONSE, $store);
    }

    /** Email address configuration */
    public function getEmailSender($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_SENDER_EMAIL, $store);
    }

    public function getAdminMail($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_ADMIN_RECEIVE_EMAIL, $store);
    }

    /** Email subject */
    public function getCustomerEmailSubject($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_SENDER_SUBJECT, $store);
    }

    public function getAdminEmailSubjectNew($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_SENDER_SUBJECT_ADMIN_NEW, $store);
    }

    public function getAdminEmailSubjectResponse($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_SENDER_SUBJECT_ADMIN_RESPOND, $store);
    }

    /** Email templates */
    public function getEmailTemplateCustomer($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_SENDER_TEMPLATE_CUSTOMER, $store);
    }

    public function getEmailTemplateAdminNew($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_SENDER_TEMPLATE_ADMIN_NEW, $store);
    }

    public function getEmailTemplateAdminRespond($store = null)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_SENDER_TEMPLATE_ADMIN_RESPOND, $store);
    }
}