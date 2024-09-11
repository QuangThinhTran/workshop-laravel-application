pipeline {
    agent any
    stages {
        stage("Verify tooling") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    sh '''
                        docker info
                        docker version
                        docker compose version
                    '''
                }
            }
        }
        stage("Verify SSH connection to server") {
            steps {
                sshagent(credentials: ['aws-ec2-workshop']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ec2-user@3.87.8.100 whoami
                    '''
                }
            }
        }
        stage("Clear all running docker containers") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    script {
                        try {
                            sh 'docker rm -f $(docker ps -a -q)'
                        } catch (Exception e) {
                            echo 'No running container to clear up...'
                        }
                    }
                }
            }
        }
        stage("Start Docker") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    sh 'make up'
                    sh 'docker compose ps'
                }
            }
        }
        stage("Populate .env file") {
            steps {
                script {
                    sh 'cp .env.example .env'
                }
            }
        }
        stage("Populate vendor folder") {
            steps {
                script {
                    def folderExists = sh(script: 'test -d vendor && echo "true" || echo "false"', returnStdout: true).trim()
                    if (folderExists == "false") {
                        sh 'composer install'
                    }
                }
            }
        }
        stage("Generate APP_KEY") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    sh 'php artisan key:generate'
                }
            }
        }
        stage("Run Tests") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    sh 'php artisan test'
                }
            }
        }
    }

    post {
        success {
            sh ' cd "/var/lib/jenkins/workspace/Workshop"'
            sh 'rm -rf artifact.zip'
            sh 'zip -r artifact.zip . -x "*node_modules**"'
            withCredentials([sshUserPrivateKey(credentialsId: "aws-ec2-workshop", keyFileVariable: 'keyfile')]) {
                sh 'scp -v -o StrictHostKeyChecking=no -i ${keyfile} /var/lib/jenkins/workspace/Workshop/artifact.zip ec2-user@3.87.8.100:/home/ec2-user/artifact'
            }
            sshagent(credentials: ['aws-ec2-workshop']) {
                sh 'ssh -o StrictHostKeyChecking=no ec2-user@3.87.8.100 unzip -o /home/ec2-user/artifact/artifact.zip -d /var/www/html'
                script {
                    try {
                        sh 'ssh -o StrictHostKeyChecking=no ec2-user@3.87.8.100 sudo chmod 777 /var/www/html/storage -R'
                    } catch (Exception e) {
                        echo 'Some file permissions could not be updated.'
                    }
                }
            }
        }
        always {
            echo 'Cleaning up...'
            sh 'docker ps'
        }
    }
}
