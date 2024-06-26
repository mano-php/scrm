# Owl Admin crm Extension

# 安装后写入默认数据
执行sql
```sql
INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, '新会员', 1, '入会时间小于等于\r\n3\r\n天', NULL, NULL, NULL, NULL);
INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, '老会员', 1, '	\r\n入会时间大于3天', NULL, NULL, NULL, NULL);
INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, '下月入会周年', 1, '入会时间是下月月份的会员', NULL, NULL, NULL, NULL);
INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, '生日当天客户', 1, '生日是当天的客户', NULL, NULL, NULL, NULL);
INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, '本周生日客户', 1, '生日是本周（自然周）的客户', NULL, NULL, NULL, NULL);
INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (7, '本月生日客户', 1, '生日是本月（自然月）的客户', NULL, NULL, NULL, NULL);
INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (8, '下月生日客户', 1, '生日是下个月的客户', NULL, NULL, NULL, NULL);

```
