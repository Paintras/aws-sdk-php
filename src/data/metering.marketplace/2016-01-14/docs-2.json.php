<?php
// This file was auto-generated from sdk-root/src/data/metering.marketplace/2016-01-14/docs-2.json
return [ 'version' => '2.0', 'service' => '<fullname>AWS Marketplace Metering Service</fullname> <p>This reference provides descriptions of the low-level AWS Marketplace Metering Service API.</p> <p>AWS Marketplace sellers can use this API to submit usage data for custom usage dimensions.</p> <p> <b>Submitting Metering Records</b> </p> <ul> <li> <p> <i>MeterUsage</i>- Submits the metering record for a Marketplace product. MeterUsage is called from an EC2 instance or a container running on EKS or ECS.</p> </li> <li> <p> <i>BatchMeterUsage</i>- Submits the metering record for a set of customers. BatchMeterUsage is called from a software-as-a-service (SaaS) application.</p> </li> </ul> <p> <b>Accepting New Customers</b> </p> <ul> <li> <p> <i>ResolveCustomer</i>- Called by a SaaS application during the registration process. When a buyer visits your website during the registration process, the buyer submits a Registration Token through the browser. The Registration Token is resolved through this API to obtain a CustomerIdentifier and Product Code.</p> </li> </ul> <p> <b>Entitlement and Metering for Paid Container Products</b> </p> <ul> <li> <p> Paid container software products sold through AWS Marketplace must integrate with the AWS Marketplace Metering Service and call the RegisterUsage operation for software entitlement and metering. Free and BYOL products for Amazon ECS or Amazon EKS aren\'t required to call RegisterUsage, but you can do so if you want to receive usage data in your seller reports. For more information on using the RegisterUsage operation, see <a href="https://docs.aws.amazon.com/marketplace/latest/userguide/container-based-products.html">Container-Based Products</a>. </p> </li> </ul> <p>BatchMeterUsage API calls are captured by AWS CloudTrail. You can use Cloudtrail to verify that the SaaS metering records that you sent are accurate by searching for records with the eventName of BatchMeterUsage. You can also use CloudTrail to audit records over time. For more information, see the <i> <a href="http://docs.aws.amazon.com/awscloudtrail/latest/userguide/cloudtrail-concepts.html">AWS CloudTrail User Guide</a> </i>.</p>', 'operations' => [ 'BatchMeterUsage' => '<p>BatchMeterUsage is called from a SaaS application listed on the AWS Marketplace to post metering records for a set of customers.</p> <p>For identical requests, the API is idempotent; requests can be retried with the same records or a subset of the input records.</p> <p>Every request to BatchMeterUsage is for one product. If you need to meter usage for multiple products, you must make multiple calls to BatchMeterUsage.</p> <p>BatchMeterUsage can process up to 25 UsageRecords at a time.</p>', 'MeterUsage' => '<p>API to emit metering records. For identical requests, the API is idempotent. It simply returns the metering record ID.</p> <p>MeterUsage is authenticated on the buyer\'s AWS account using credentials from the EC2 instance, ECS task, or EKS pod.</p>', 'RegisterUsage' => '<p>Paid container software products sold through AWS Marketplace must integrate with the AWS Marketplace Metering Service and call the RegisterUsage operation for software entitlement and metering. Free and BYOL products for Amazon ECS or Amazon EKS aren\'t required to call RegisterUsage, but you may choose to do so if you would like to receive usage data in your seller reports. The sections below explain the behavior of RegisterUsage. RegisterUsage performs two primary functions: metering and entitlement.</p> <ul> <li> <p> <i>Entitlement</i>: RegisterUsage allows you to verify that the customer running your paid software is subscribed to your product on AWS Marketplace, enabling you to guard against unauthorized use. Your container image that integrates with RegisterUsage is only required to guard against unauthorized use at container startup, as such a CustomerNotSubscribedException/PlatformNotSupportedException will only be thrown on the initial call to RegisterUsage. Subsequent calls from the same Amazon ECS task instance (e.g. task-id) or Amazon EKS pod will not throw a CustomerNotSubscribedException, even if the customer unsubscribes while the Amazon ECS task or Amazon EKS pod is still running.</p> </li> <li> <p> <i>Metering</i>: RegisterUsage meters software use per ECS task, per hour, or per pod for Amazon EKS with usage prorated to the second. A minimum of 1 minute of usage applies to tasks that are short lived. For example, if a customer has a 10 node Amazon ECS or Amazon EKS cluster and a service configured as a Daemon Set, then Amazon ECS or Amazon EKS will launch a task on all 10 cluster nodes and the customer will be charged: (10 * hourly_rate). Metering for software use is automatically handled by the AWS Marketplace Metering Control Plane -- your software is not required to perform any metering specific actions, other than call RegisterUsage once for metering of software use to commence. The AWS Marketplace Metering Control Plane will also continue to bill customers for running ECS tasks and Amazon EKS pods, regardless of the customers subscription state, removing the need for your software to perform entitlement checks at runtime.</p> </li> </ul>', 'ResolveCustomer' => '<p>ResolveCustomer is called by a SaaS application during the registration process. When a buyer visits your website during the registration process, the buyer submits a registration token through their browser. The registration token is resolved through this API to obtain a CustomerIdentifier and product code.</p>', ], 'shapes' => [ 'BatchMeterUsageRequest' => [ 'base' => '<p>A BatchMeterUsageRequest contains UsageRecords, which indicate quantities of usage within your application.</p>', 'refs' => [], ], 'BatchMeterUsageResult' => [ 'base' => '<p>Contains the UsageRecords processed by BatchMeterUsage and any records that have failed due to transient error.</p>', 'refs' => [], ], 'Boolean' => [ 'base' => NULL, 'refs' => [ 'MeterUsageRequest$DryRun' => '<p>Checks whether you have the permissions required for the action, but does not make the request. If you have the permissions, the request returns DryRunOperation; otherwise, it returns UnauthorizedException. Defaults to <code>false</code> if not specified.</p>', ], ], 'CustomerIdentifier' => [ 'base' => NULL, 'refs' => [ 'ResolveCustomerResult$CustomerIdentifier' => '<p>The CustomerIdentifier is used to identify an individual customer in your application. Calls to BatchMeterUsage require CustomerIdentifiers for each UsageRecord.</p>', 'UsageRecord$CustomerIdentifier' => '<p>The CustomerIdentifier is obtained through the ResolveCustomer operation and represents an individual buyer in your application.</p>', ], ], 'CustomerNotEntitledException' => [ 'base' => '<p>Exception thrown when the customer does not have a valid subscription for the product.</p>', 'refs' => [], ], 'DisabledApiException' => [ 'base' => '<p>The API is disabled in the Region.</p>', 'refs' => [], ], 'DuplicateRequestException' => [ 'base' => '<p>A metering record has already been emitted by the same EC2 instance, ECS task, or EKS pod for the given {usageDimension, timestamp} with a different usageQuantity.</p>', 'refs' => [], ], 'ExpiredTokenException' => [ 'base' => '<p>The submitted registration token has expired. This can happen if the buyer\'s browser takes too long to redirect to your page, the buyer has resubmitted the registration token, or your application has held on to the registration token for too long. Your SaaS registration website should redeem this token as soon as it is submitted by the buyer\'s browser.</p>', 'refs' => [], ], 'InternalServiceErrorException' => [ 'base' => '<p>An internal error has occurred. Retry your request. If the problem persists, post a message with details on the AWS forums.</p>', 'refs' => [], ], 'InvalidCustomerIdentifierException' => [ 'base' => '<p>You have metered usage for a CustomerIdentifier that does not exist.</p>', 'refs' => [], ], 'InvalidEndpointRegionException' => [ 'base' => '<p>The endpoint being called is in a AWS Region different from your EC2 instance, ECS task, or EKS pod. The Region of the Metering Service endpoint and the AWS Region of the resource must match.</p>', 'refs' => [], ], 'InvalidProductCodeException' => [ 'base' => '<p>The product code passed does not match the product code used for publishing the product.</p>', 'refs' => [], ], 'InvalidPublicKeyVersionException' => [ 'base' => '<p>Public Key version is invalid.</p>', 'refs' => [], ], 'InvalidRegionException' => [ 'base' => '<p>RegisterUsage must be called in the same AWS Region the ECS task was launched in. This prevents a container from hardcoding a Region (e.g. withRegion(“us-east-1”) when calling RegisterUsage.</p>', 'refs' => [], ], 'InvalidTokenException' => [ 'base' => '<p>Registration token is invalid.</p>', 'refs' => [], ], 'InvalidUsageDimensionException' => [ 'base' => '<p>The usage dimension does not match one of the UsageDimensions associated with products.</p>', 'refs' => [], ], 'MeterUsageRequest' => [ 'base' => NULL, 'refs' => [], ], 'MeterUsageResult' => [ 'base' => NULL, 'refs' => [], ], 'NonEmptyString' => [ 'base' => NULL, 'refs' => [ 'RegisterUsageResult$Signature' => '<p>JWT Token</p>', 'ResolveCustomerRequest$RegistrationToken' => '<p>When a buyer visits your website during the registration process, the buyer submits a registration token through the browser. The registration token is resolved to obtain a CustomerIdentifier and product code.</p>', ], ], 'Nonce' => [ 'base' => NULL, 'refs' => [ 'RegisterUsageRequest$Nonce' => '<p>(Optional) To scope down the registration to a specific running software instance and guard against replay attacks.</p>', ], ], 'PlatformNotSupportedException' => [ 'base' => '<p>AWS Marketplace does not support metering usage from the underlying platform. Currently, only Amazon ECS is supported.</p>', 'refs' => [], ], 'ProductCode' => [ 'base' => NULL, 'refs' => [ 'BatchMeterUsageRequest$ProductCode' => '<p>Product code is used to uniquely identify a product in AWS Marketplace. The product code should be the same as the one used during the publishing of a new product.</p>', 'MeterUsageRequest$ProductCode' => '<p>Product code is used to uniquely identify a product in AWS Marketplace. The product code should be the same as the one used during the publishing of a new product.</p>', 'RegisterUsageRequest$ProductCode' => '<p>Product code is used to uniquely identify a product in AWS Marketplace. The product code should be the same as the one used during the publishing of a new product.</p>', 'ResolveCustomerResult$ProductCode' => '<p>The product code is returned to confirm that the buyer is registering for your product. Subsequent BatchMeterUsage calls should be made using this product code.</p>', ], ], 'RegisterUsageRequest' => [ 'base' => NULL, 'refs' => [], ], 'RegisterUsageResult' => [ 'base' => NULL, 'refs' => [], ], 'ResolveCustomerRequest' => [ 'base' => '<p>Contains input to the ResolveCustomer operation.</p>', 'refs' => [], ], 'ResolveCustomerResult' => [ 'base' => '<p>The result of the ResolveCustomer operation. Contains the CustomerIdentifier and product code.</p>', 'refs' => [], ], 'String' => [ 'base' => NULL, 'refs' => [ 'MeterUsageResult$MeteringRecordId' => '<p>Metering record id.</p>', 'UsageRecordResult$MeteringRecordId' => '<p>The MeteringRecordId is a unique identifier for this metering event.</p>', ], ], 'ThrottlingException' => [ 'base' => '<p>The calls to the API are throttled.</p>', 'refs' => [], ], 'Timestamp' => [ 'base' => NULL, 'refs' => [ 'MeterUsageRequest$Timestamp' => '<p>Timestamp, in UTC, for which the usage is being reported. Your application can meter usage for up to one hour in the past. Make sure the timestamp value is not before the start of the software usage.</p>', 'RegisterUsageResult$PublicKeyRotationTimestamp' => '<p>(Optional) Only included when public key version has expired</p>', 'UsageRecord$Timestamp' => '<p>Timestamp, in UTC, for which the usage is being reported.</p> <p>Your application can meter usage for up to one hour in the past. Make sure the timestamp value is not before the start of the software usage.</p>', ], ], 'TimestampOutOfBoundsException' => [ 'base' => '<p>The timestamp value passed in the meterUsage() is out of allowed range.</p>', 'refs' => [], ], 'UsageDimension' => [ 'base' => NULL, 'refs' => [ 'MeterUsageRequest$UsageDimension' => '<p>It will be one of the fcp dimension name provided during the publishing of the product.</p>', 'UsageRecord$Dimension' => '<p>During the process of registering a product on AWS Marketplace, up to eight dimensions are specified. These represent different units of value in your application.</p>', ], ], 'UsageQuantity' => [ 'base' => NULL, 'refs' => [ 'MeterUsageRequest$UsageQuantity' => '<p>Consumption value for the hour. Defaults to <code>0</code> if not specified.</p>', 'UsageRecord$Quantity' => '<p>The quantity of usage consumed by the customer for the given dimension and time. Defaults to <code>0</code> if not specified.</p>', ], ], 'UsageRecord' => [ 'base' => '<p>A UsageRecord indicates a quantity of usage for a given product, customer, dimension and time.</p> <p>Multiple requests with the same UsageRecords as input will be deduplicated to prevent double charges.</p>', 'refs' => [ 'UsageRecordList$member' => NULL, 'UsageRecordResult$UsageRecord' => '<p>The UsageRecord that was part of the BatchMeterUsage request.</p>', ], ], 'UsageRecordList' => [ 'base' => NULL, 'refs' => [ 'BatchMeterUsageRequest$UsageRecords' => '<p>The set of UsageRecords to submit. BatchMeterUsage accepts up to 25 UsageRecords at a time.</p>', 'BatchMeterUsageResult$UnprocessedRecords' => '<p>Contains all UsageRecords that were not processed by BatchMeterUsage. This is a list of UsageRecords. You can retry the failed request by making another BatchMeterUsage call with this list as input in the BatchMeterUsageRequest.</p>', ], ], 'UsageRecordResult' => [ 'base' => '<p>A UsageRecordResult indicates the status of a given UsageRecord processed by BatchMeterUsage.</p>', 'refs' => [ 'UsageRecordResultList$member' => NULL, ], ], 'UsageRecordResultList' => [ 'base' => NULL, 'refs' => [ 'BatchMeterUsageResult$Results' => '<p>Contains all UsageRecords processed by BatchMeterUsage. These records were either honored by AWS Marketplace Metering Service or were invalid.</p>', ], ], 'UsageRecordResultStatus' => [ 'base' => NULL, 'refs' => [ 'UsageRecordResult$Status' => '<p>The UsageRecordResult Status indicates the status of an individual UsageRecord processed by BatchMeterUsage.</p> <ul> <li> <p> <i>Success</i>- The UsageRecord was accepted and honored by BatchMeterUsage.</p> </li> <li> <p> <i>CustomerNotSubscribed</i>- The CustomerIdentifier specified is not subscribed to your product. The UsageRecord was not honored. Future UsageRecords for this customer will fail until the customer subscribes to your product.</p> </li> <li> <p> <i>DuplicateRecord</i>- Indicates that the UsageRecord was invalid and not honored. A previously metered UsageRecord had the same customer, dimension, and time, but a different quantity.</p> </li> </ul>', ], ], 'VersionInteger' => [ 'base' => NULL, 'refs' => [ 'RegisterUsageRequest$PublicKeyVersion' => '<p>Public Key Version provided by AWS Marketplace</p>', ], ], 'errorMessage' => [ 'base' => NULL, 'refs' => [ 'CustomerNotEntitledException$message' => NULL, 'DisabledApiException$message' => NULL, 'DuplicateRequestException$message' => NULL, 'ExpiredTokenException$message' => NULL, 'InternalServiceErrorException$message' => NULL, 'InvalidCustomerIdentifierException$message' => NULL, 'InvalidEndpointRegionException$message' => NULL, 'InvalidProductCodeException$message' => NULL, 'InvalidPublicKeyVersionException$message' => NULL, 'InvalidRegionException$message' => NULL, 'InvalidTokenException$message' => NULL, 'InvalidUsageDimensionException$message' => NULL, 'PlatformNotSupportedException$message' => NULL, 'ThrottlingException$message' => NULL, 'TimestampOutOfBoundsException$message' => NULL, ], ], ],];
