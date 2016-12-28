# Assignments
## Assignment 1
Write a PHP function that accepts an integer as a parameter and
outputs a numbered and sorted list of all prime numbers that are
smaller than the supplied number.

Make sure to change the first line to execute PHP where it is
installed on your system

### Example
` ./assignment_1.php 29 ` outputs

``` 
1. 2
2. 3
3. 5
4. 7
5. 11
6. 13
7. 17
8. 19
9. 23 
```
 
 ## Assignment 2
 # Should give output 1 (See desired outputs below)
 php assignment2.php
 
 # Should give output 2 (See desired outputs below)
 php assignment2.php --instances 2 --instance-type t2.small 
   --allow-ssh-from 172.16.8.30
 
 In addition, both commands for assignment #2 should render a 
 HTML page with clear syntax highlighting. You can earn bonus 
 points by creating a mechanism to apply the template using 
 the aws cli and for monitoring and reporting the status of 
 the template's deployment.

####
Assignment 2 creates a `template.html` file with syntax highlighting

```json
Outputs:

Output #1

{
  "AWSTemplateFormatVersion": "2010-09-09",
  "Outputs": {
    "PublicIP": {
      "Description": "Public IP address of the newly created EC2 instance",
      "Value": {
        "Fn::GetAtt": [
          "EC2Instance",
          "PublicIp"
        ]
      }
    }
  },
  "Resources": {
    "EC2Instance": {
      "Properties": {
        "ImageId": "ami-b97a12ce",
        "InstanceType": "t2.micro",
        "SecurityGroups": [
          {
            "Ref": "InstanceSecurityGroup"
          }
        ]
      },
      "Type": "AWS::EC2::Instance"
    },
    "InstanceSecurityGroup": {
      "Properties": {
        "GroupDescription": "Enable SSH access via port 22",
        "SecurityGroupIngress": [
          {
            "CidrIp": "0.0.0.0/0",
            "FromPort": "22",
            "IpProtocol": "tcp",
            "ToPort": "22"
          }
        ]
      },
      "Type": "AWS::EC2::SecurityGroup"
    }
  }
}


Output #2

{
  "AWSTemplateFormatVersion": "2010-09-09",
  "Outputs": {
    "PublicIP": {
      "Description": "Public IP address of the newly created EC2 instance",
      "Value": {
        "Fn::GetAtt": [
          "EC2Instance",
          "PublicIp"
        ]
      }
    }
  },
  "Resources": {
    "EC2Instance": {
      "Properties": {
        "ImageId": "ami-b97a12ce",
        "InstanceType": "t2.small",
        "SecurityGroups": [
          {
            "Ref": "InstanceSecurityGroup"
          }
        ]
      },
      "Type": "AWS::EC2::Instance"
    },
    "EC2Instance2": {
      "Properties": {
        "ImageId": "ami-b97a12ce",
        "InstanceType": "t2.small",
        "SecurityGroups": [
          {
            "Ref": "InstanceSecurityGroup"
          }
        ]
      },
      "Type": "AWS::EC2::Instance"
    },
    "InstanceSecurityGroup": {
      "Properties": {
        "GroupDescription": "Enable SSH access via port 22",
        "SecurityGroupIngress": [
          {
            "CidrIp": "172.16.8.30/32",
            "FromPort": "22",
            "IpProtocol": "tcp",
            "ToPort": "22"
          }
        ]
      },
      "Type": "AWS::EC2::SecurityGroup"
    }
  }
}
```
